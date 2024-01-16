import { useEffect, useState } from 'react'

import { EsriProvider } from 'leaflet-geosearch'
import { MapDetermination } from '../components'
import { useTranslation } from 'react-i18next'

export default function CreateStorePage() {
    const { t } = useTranslation()
    const [address, setAddress] = useState('')
    const [name, setName] = useState('')
    const [coordinates, setCoordinates] = useState([0, 0])
    const [showMarker, setShowMarker] = useState(false)
    const provider = new EsriProvider()

    const handleNameChange = e => {
        setName(e.target.value)
    }

    const handleAddressChange = e => {
        provider.search({ query: e.target.value }).then(result => {
            setCoordinates([result[0].y, result[0].x])
            setShowMarker(!showMarker)
        })
        setAddress(e.target.value)
    }

    useEffect(() => {
        const queryString = new URL(window.location.href)
        const urlParams = new URLSearchParams(queryString.search)
        if (urlParams.size === 3) {
            fetch(
                'https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?f=pjson&langCode=EN&location=' +
                    urlParams.get('lng') +
                    ',' +
                    urlParams.get('lat'),
            )
                .then(result => result.json())
                .then(result => {
                    setShowMarker(true)
                    setCoordinates([urlParams.get('lat'), urlParams.get('lng')])
                    setAddress(result.address.Match_addr)
                })
        }
    }, [])

    return (
        <>
            <label className="mr-1 block text-sm font-bold text-gray-700" htmlFor="name">
                {t('contact.StoreName')}:
            </label>
            <input
                type="text"
                id="name"
                name="name"
                className="w-full rounded-md border p-2"
                onChange={handleNameChange}
                value={name}
            />
            <label className="mr-1 block text-sm font-bold text-gray-700" htmlFor="address">
                {t('contact.Address')}:
            </label>
            <input
                type="text"
                id="address"
                name="address"
                className="w-full rounded-md border p-2"
                onChange={handleAddressChange}
                value={address}
            />
            <label className="mr-1 block text-sm font-bold text-gray-700">
                {t('contact.location')}:
            </label>
            <MapDetermination provider={provider} marker={{ isShow: showMarker, coordinates }} />
            <input type="hidden" name="location" value={Object.values(coordinates)} />
        </>
    )
}
