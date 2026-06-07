import { defineConfig, type Plugin } from 'vite'
import vue from '@vitejs/plugin-vue'
import {
  readFileSync, readdirSync, statSync, rmSync, existsSync, cpSync, mkdirSync, createReadStream,
} from 'node:fs'
import { resolve, join, dirname, extname } from 'node:path'

// Live data (edited via the PHP admin panel at runtime). Stored in seed/ as a template,
// and in dist/ as the working copy that the build does NOT overwrite.
const SEED_DIRS = ['data', 'images']
// Image directories managed by the admin panel (may accumulate orphans).
const MANAGED_DIRS = ['images/menu', 'images/site']
// Data files from which we collect image references.
const DATA_FILES = ['data/menu.json', 'data/settings.json']

const MIME: Record<string, string> = {
  '.json': 'application/json',
  '.webp': 'image/webp',
  '.png': 'image/png',
  '.jpg': 'image/jpeg',
  '.jpeg': 'image/jpeg',
  '.gif': 'image/gif',
  '.svg': 'image/svg+xml',
  '.ico': 'image/x-icon',
}

// Recursively copies src->dest WITHOUT overwriting existing files (seed-if-missing).
function copyMissing(src: string, dest: string) {
  if (!existsSync(src)) return
  for (const name of readdirSync(src)) {
    const s = join(src, name)
    const d = join(dest, name)
    if (statSync(s).isDirectory()) {
      copyMissing(s, d)
    } else if (!existsSync(d)) {
      mkdirSync(dirname(d), { recursive: true })
      cpSync(s, d)
    }
  }
}

// Recursively collects all "/images/..." strings from an arbitrary JSON.
function collectImageRefs(value: unknown, out: Set<string>) {
  if (typeof value === 'string') {
    if (value.startsWith('/images/')) out.add(value.replace(/^\//, ''))
  } else if (Array.isArray(value)) {
    for (const v of value) collectImageRefs(v, out)
  } else if (value && typeof value === 'object') {
    for (const v of Object.values(value)) collectImageRefs(v, out)
  }
}

// Removes images in managed dist/ directories that are not referenced in data/*.json.
// Always keeps .svg. If there is no data/references, removes nothing.
function pruneUnusedImages(dist: string) {
  const refs = new Set<string>()
  let dataOk = false
  for (const f of DATA_FILES) {
    const p = join(dist, f)
    if (!existsSync(p)) continue
    try {
      collectImageRefs(JSON.parse(readFileSync(p, 'utf8')), refs)
      dataOk = true
    } catch { /* the guard below will handle it */ }
  }
  if (!dataOk || refs.size === 0) {
    console.log('[mutable-data] prune пропущено: посилань на зображення не знайдено')
    return
  }
  let removed = 0
  for (const dir of MANAGED_DIRS) {
    const abs = join(dist, dir)
    if (!existsSync(abs)) continue
    for (const name of readdirSync(abs)) {
      if (name.toLowerCase().endsWith('.svg')) continue
      if (refs.has(`${dir}/${name}`)) continue
      const full = join(abs, name)
      if (!statSync(full).isFile()) continue
      rmSync(full)
      removed++
      console.log(`[mutable-data] видалено невикористане ${dir}/${name}`)
    }
  }
  console.log(`[mutable-data] prune: прибрано ${removed} файл(ів)`)
}

// Separates the "template" (seed/) from "live data" (dist/):
//  - build: does not clean data/images in dist, only seeds what is missing; cleans only dist/assets;
//  - dev: serves /data and /images from seed/, since they no longer live in public/.
function mutableData(): Plugin {
  const root = process.cwd()
  const seed = resolve(root, 'seed')
  const dist = resolve(root, 'dist')
  return {
    name: 'mutable-data',
    enforce: 'post',
    // Clean only the built bundles (since emptyOutDir is disabled), leaving live data untouched.
    buildStart() {
      const assets = join(dist, 'assets')
      if (existsSync(assets)) rmSync(assets, { recursive: true, force: true })
    },
    closeBundle() {
      for (const dir of SEED_DIRS) copyMissing(join(seed, dir), join(dist, dir))
      pruneUnusedImages(dist)
    },
    configureServer(server) {
      server.middlewares.use((req, res, next) => {
        const url = (req.url ?? '').split('?')[0]
        const top = url.split('/')[1]
        if (top !== 'data' && top !== 'images') return next()
        const file = join(seed, url.replace(/^\//, ''))
        if (!existsSync(file) || !statSync(file).isFile()) return next()
        res.setHeader('Content-Type', MIME[extname(file).toLowerCase()] ?? 'application/octet-stream')
        createReadStream(file).pipe(res)
      })
    },
  }
}

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue(), mutableData()],
  resolve: {
    alias: {
      '@': resolve(process.cwd(), 'src'),
    },
  },
  build: {
    // Do not wipe dist entirely - it holds live data (data/, images/) written by the admin panel.
    emptyOutDir: false,
  },
})
