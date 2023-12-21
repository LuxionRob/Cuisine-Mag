import { useEffect } from 'react'
import L from 'leaflet'
import { useMap } from 'react-leaflet'
import 'leaflet.heat'

export default function HeatMap({ points }) {
    const map = useMap()

    useEffect(() => {
        const heat = L.heatLayer(points).addTo(map)
        return () => map.removeLayer(heat)
    }, [points])

    return null
}
