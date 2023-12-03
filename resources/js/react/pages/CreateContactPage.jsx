import { useState } from 'react'
import { useTranslation } from 'react-i18next'
import { MapDetermination } from '../components'
import { EsriProvider } from 'leaflet-geosearch'
import { add } from '../api/addContact'
import { marker } from 'leaflet'

export default function CreateContactPage() {
    const { t } = useTranslation()
    const [address, setAddress] = useState('')
    const [name, setName] = useState('')
    const [phoneNumber, setPhoneNumber] = useState('')
    const [coordinate, setCoordinate] = useState({ x: 0, y: 0 })
    const [showMarker, setShowMarker] = useState(false)
    const provider = new EsriProvider()

    const handleNameChange = e => {
        setName(e.target.value)
    }

    const handlePhoneNumberChange = e => {
        setPhoneNumber(e.target.value)
    }

    const handleAddressChange = e => {
        provider.search({ query: e.target.value }).then(result => {
            setCoordinate({ x: result[0].y, y: result[0].x })
            setShowMarker(!showMarker)
        })
        setAddress(e.target.value)
    }

    return (
        <>
            <label htmlFor="name">{t('contact.Name')}</label>
            <input
                type="text"
                id="name"
                name="name"
                className="w-full rounded-md border p-2"
                onChange={handleNameChange}
                value={name}
            />
            <label htmlFor="address">{t('contact.Address')}</label>
            <input
                type="text"
                id="address"
                name="address"
                className="w-full rounded-md border p-2"
                onChange={handleAddressChange}
                value={address}
            />
            <label htmlFor="phone_number">{t('contact.Phone number')}</label>
            <input
                type="number"
                id="phone_number"
                name="phone_number"
                className="w-full rounded-md border p-2"
                onChange={handlePhoneNumberChange}
                value={phoneNumber}
            />
            <label>{t('contact.location')}</label>
            <MapDetermination provider={provider} marker={{ isShow: showMarker, ...coordinate }} />
            <input type="hidden" name="location" value={Object.values(coordinate)} />
            <button type="submit" className="button primary mr-4 mt-4">
                {t('contact.create.button')}
            </button>
            <a
                href="{{ route('users.show', Auth::id()) }}"
                className="text-gray-500 hover:text-gray-700"
            >
                {t('Cancel')}
            </a>
        </>
    )
}
