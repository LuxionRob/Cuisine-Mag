import 'leaflet.heat'

import L from 'leaflet'
import { useEffect } from 'react'
import { useMap } from 'react-leaflet'

export default function HeatMap({ points }) {
    const map = useMap()

    useEffect(() => {
        var legend = L.control({ position: 'bottomright' })

        legend.onAdd = function (map) {
            var div = L.DomUtil.create('div', 'legend')

            div.innerHTML += '<h4>Density</h4>'
            div.innerHTML += `<div id='density' style="background: linear-gradient(to left, #ff0000, #40ff00); height: 18px;"></div>`

            return div
        }

        legend.addTo(map)
    }, [])

    useEffect(() => {
        const heat = L.heatLayer(points).addTo(map)
        return () => map.removeLayer(heat)
    }, [points])

    return null
}
