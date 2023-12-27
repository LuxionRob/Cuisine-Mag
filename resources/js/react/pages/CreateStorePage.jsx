import { useState } from 'react'
import { useTranslation } from 'react-i18next'
import { MapDetermination } from '../components'
import { EsriProvider } from 'leaflet-geosearch'

export default function CreateStorePage() {
    const { t } = useTranslation()
    const [address, setAddress] = useState('')
    const [name, setName] = useState('')
    const [coordinates, setCoordinates] = useState({ x: 0, y: 0 })
    const [showMarker, setShowMarker] = useState(false)
    const provider = new EsriProvider()

    const handleNameChange = e => {
        setName(e.target.value)
    }

    const handleAddressChange = e => {
        provider.search({ query: e.target.value }).then(result => {
            setCoordinates({ x: result[0].y, y: result[0].x })
            setShowMarker(!showMarker)
        })
        setAddress(e.target.value)
    }
    return (
        <>
            <label htmlFor="name">{t('contact.StoreName')}</label>
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
            <label>{t('contact.location')}</label>
            <MapDetermination provider={provider} marker={{ isShow: showMarker, ...coordinates }} />
            <input type="hidden" name="location" value={Object.values(coordinates)} />
        </>
    )
}
