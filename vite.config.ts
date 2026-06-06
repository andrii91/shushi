import { defineConfig, type Plugin } from 'vite'
import vue from '@vitejs/plugin-vue'
import {
  readFileSync, readdirSync, statSync, rmSync, existsSync, cpSync, mkdirSync, createReadStream,
} from 'node:fs'
import { resolve, join, dirname, extname } from 'node:path'

// Живі дані (редагуються через PHP-адмінку в рантаймі). Лежать у seed/ як шаблон,
// у dist/ — як робоча копія, яку білд НЕ перезаписує.
const SEED_DIRS = ['data', 'images']
// Теки із зображеннями, якими керує адмінка (можуть накопичувати «сироти»).
const MANAGED_DIRS = ['images/menu', 'images/site']
// Файли-дані, з яких збираємо посилання на зображення.
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

// Рекурсивно копіює src→dest, НЕ перезаписуючи наявні файли (seed-if-missing).
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

// Рекурсивно збирає всі рядки виду "/images/..." з довільного JSON.
function collectImageRefs(value: unknown, out: Set<string>) {
  if (typeof value === 'string') {
    if (value.startsWith('/images/')) out.add(value.replace(/^\//, ''))
  } else if (Array.isArray(value)) {
    for (const v of value) collectImageRefs(v, out)
  } else if (value && typeof value === 'object') {
    for (const v of Object.values(value)) collectImageRefs(v, out)
  }
}

// Видаляє з dist/ зображення в керованих теках, на які немає посилань у data/*.json.
// Завжди лишає .svg. Якщо даних/посилань нема — нічого не видаляє.
function pruneUnusedImages(dist: string) {
  const refs = new Set<string>()
  let dataOk = false
  for (const f of DATA_FILES) {
    const p = join(dist, f)
    if (!existsSync(p)) continue
    try {
      collectImageRefs(JSON.parse(readFileSync(p, 'utf8')), refs)
      dataOk = true
    } catch { /* спрацює запобіжник нижче */ }
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

// Розділяє «шаблон» (seed/) і «живі дані» (dist/):
//  • build: не чистить data/images у dist, лише засіває відсутнє; чистить лише dist/assets;
//  • dev: віддає /data та /images із seed/, бо в public/ їх більше немає.
function mutableData(): Plugin {
  const root = process.cwd()
  const seed = resolve(root, 'seed')
  const dist = resolve(root, 'dist')
  return {
    name: 'mutable-data',
    enforce: 'post',
    // Чистимо лише зібрані бандли (бо emptyOutDir вимкнено), не чіпаючи живі дані.
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
  build: {
    // Не витирати dist цілком — там живі дані (data/, images/), які пише адмінка.
    emptyOutDir: false,
  },
})
