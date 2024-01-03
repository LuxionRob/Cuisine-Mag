import React from 'react'
import ReactDOM from 'react-dom/client'
import i18n from './locales/translation'
import { I18nextProvider } from 'react-i18next'
import '../../../node_modules/leaflet/dist/leaflet.css'

import { CreateContactPage, AnalyzeMapPage, DashboardPage, CreateStorePage } from './pages'

if (document.getElementById('create-contact-form')) {
    const root = ReactDOM.createRoot(document.getElementById('create-contact-form'))
    root.render(
        <I18nextProvider lng="vi" i18n={i18n}>
            <CreateContactPage />
        </I18nextProvider>,
    )
}

if (document.querySelector('select#role')) {
    const render = e => {
        const root = ReactDOM.createRoot(document.getElementById('create-store-page'))
        if (document.querySelector('select#role').value === 'SALESMAN') {
            if (document.getElementById('create-store-page')) {
                root.render(
                    <I18nextProvider lng="vi" i18n={i18n}>
                        <CreateStorePage />
                    </I18nextProvider>,
                )
            }
        } else {
            root.unmount()
        }
    }
    document.querySelector('select#role').addEventListener('change', render)
    window.addEventListener('load', render)
}

if (document.getElementById('analyze-map')) {
    const root = ReactDOM.createRoot(document.getElementById('analyze-map'))
    root.render(
        <I18nextProvider lng="vi" i18n={i18n}>
            <AnalyzeMapPage />
        </I18nextProvider>,
    )
}

if (document.getElementById('dashboard-analyze-page')) {
    const root = ReactDOM.createRoot(document.getElementById('dashboard-analyze-page'))
    root.render(
        <I18nextProvider lng="vi" i18n={i18n}>
            <DashboardPage />
        </I18nextProvider>,
    )
}
