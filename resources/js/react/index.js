import React from 'react'
import ReactDOM from 'react-dom/client'
import i18n from './locales/translation'
import { I18nextProvider } from 'react-i18next'
import '../../../node_modules/leaflet/dist/leaflet.css'

import { CreateContactPage, AnalyzeMapPage } from './pages'
import App from './App'

if (document.getElementById('create-contact-form')) {
    const root = ReactDOM.createRoot(document.getElementById('create-contact-form'))
    root.render(
        <I18nextProvider lng="vi" i18n={i18n}>
            <CreateContactPage />
        </I18nextProvider>,
    )
}

if (document.getElementById('analyze-map')) {
    const root = ReactDOM.createRoot(document.getElementById('analyze-map'))
    root.render(
        <I18nextProvider lng="vi" i18n={i18n}>
            <AnalyzeMapPage />
        </I18nextProvider>,
    )
}

if (document.getElementById('dashboard')) {
    const root = ReactDOM.createRoot(document.getElementById('dashboard'))
    root.render(
        <I18nextProvider lng="vi" i18n={i18n}>
            <App />
        </I18nextProvider>,
    )
}
