// src/plugins/gtag.js

export default {
  install: (app, options) => {
    const trackingId = options.trackingId

    if (!trackingId) {
      console.warn('[GTag] trackingId не вказано')
      return
    }

    // Додаємо gtag.js скрипт у DOM
    const script = document.createElement('script')
    script.setAttribute('async', '')
    script.setAttribute('src', `https://www.googletagmanager.com/gtag/js?id=${trackingId}`)
    document.head.appendChild(script)

    // Ініціалізуємо Google Analytics
    window.dataLayer = window.dataLayer || []
    function gtag(){ dataLayer.push(arguments) }

    window.gtag = gtag
    gtag('js', new Date())
    gtag('config', trackingId)

    // Робимо доступ до gtag через глобальний метод
    app.config.globalProperties.$gtag = gtag
  }
}
