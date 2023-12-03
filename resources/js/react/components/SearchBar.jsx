import { useEffect } from 'react'
import { useMap } from 'react-leaflet'
import { SearchControl } from 'leaflet-geosearch'
import 'leaflet-geosearch/dist/geosearch.css'

export default function SearchBar({ provider }) {
    const searchControl = new SearchControl({
        provider: provider,
        region: 'nl', // prioritize matches within The Netherlands
    })

    const map = useMap()

    useEffect(() => {
        map.addControl(searchControl)
        return () => map.removeControl(searchControl)
    }, [])

    return null
}
