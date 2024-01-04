import 'leaflet.heat'

import L from 'leaflet'
import { useEffect } from 'react'
import { useMap } from 'react-leaflet'

export default function HeatMap({ points }) {
    const map = useMap()

    useEffect(() => {
        const heat = L.heatLayer(points).addTo(map)
        return () => map.removeLayer(heat)
    }, [points])

    return null
}
