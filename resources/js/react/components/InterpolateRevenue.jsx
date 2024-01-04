import L from 'leaflet'
import { useMap } from 'react-leaflet'
import { useEffect } from 'react'

export default function InterpolateRevenue({ data }) {
    const map = useMap()

    useEffect(() => {
        const geojson = L.geoJson(data, {
            style: function (feature) {
                if (feature.properties.rate >= 0.9) {
                    return { color: '#219C90' }
                } else if (feature.properties.rate >= 0.8) {
                    return { color: '#E9B824' }
                } else if (feature.properties.rate >= 0.7) {
                    return { color: '#EE9322' }
                } else if (feature.properties.rate >= 0.6) {
                    return { color: '#D83F31' }
                }
                return { color: '#EEE2DE' }
            },
            onEachFeature: function (feature, layer) {
                layer.bindPopup(
                    '<span>RPR: </span><strong>' +
                        Math.round(feature.properties.rate * 100) / 100 +
                        '</strong>',
                )
            },
        }).addTo(map)
        return () => map.removeLayer(geojson)
    }, [])

    return null
}
