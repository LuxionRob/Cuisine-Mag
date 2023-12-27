import L from 'leaflet'
import { useMap } from 'react-leaflet'
import { useEffect } from 'react'

export default function InterpolateRevenue({ data }) {
    const map = useMap()

    useEffect(() => {
        const geojson = L.geoJson(data, {
            onEachFeature: function (feature, layer) {
                layer.bindPopup(
                    '<span>Revenue: </span><strong>' + feature.properties.revenue + '</strong>',
                )
            },
        }).addTo(map)
        return () => map.removeLayer(geojson)
    }, [])

    return null
}
