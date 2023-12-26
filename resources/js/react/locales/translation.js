import i18n from 'i18next'
import { initReactI18next } from 'react-i18next'
import translationEN from './en/translation.json'
import translationVI from './vi/translation.json'

const resources = {
    en: {
        translation: translationEN,
    },
    vi: {
        translation: translationVI,
    },
}

i18n.use(initReactI18next).init({
    resources,
    fallbackLng: window.locale,
    debug: false,
    interpolation: {
        escapeValue: false, // not needed for react as it escapes by default
    },
})

export default i18n
