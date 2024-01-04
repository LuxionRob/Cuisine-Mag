import '../../../css/style.css'

import React, { useEffect } from 'react'

import L from 'leaflet'
import { useMap } from 'react-leaflet'

function MapLegend() {
    const map = useMap()

    useEffect(() => {
        // Road legend
        const roadLegend = L.control({ position: 'bottomleft' })

        roadLegend.onAdd = function () {
            const div = L.DomUtil.create('div', 'legend-road-type')

            const categories = [
                'primary',
                'secondary',
                'tertiary',
                'trunk',
                'service',
                'residential',
                'living_street',
            ]

            const colors = [
                '#9e7fa9',
                '#bba683',
                '#d5b78a',
                '#cabaa2',
                '#d0d63f',
                '#e388bf',
                '#f5e9b7',
            ]

            div.innerHTML += '<h4>Road type</h4>'
            for (let i = 0; i < categories.length; i++) {
                div.innerHTML += `<i style="background: ${colors[i]}"></i><span>${categories[i]}</span><br>`
            }

            return div
        }

        roadLegend.addTo(map)

        // Heatmap legend
        const heatMapLegend = L.control({ position: 'bottomright' })

        heatMapLegend.onAdd = function () {
            const div = L.DomUtil.create('div', 'legend-density')

            div.innerHTML += '<h4>Density</h4>'
            div.innerHTML += `<div id='density' style="background: linear-gradient(to left, #ff0000, #40ff00); height: 18px;"></div>`

            return div
        }

        heatMapLegend.addTo(map)
    }, [])

    return null
}

export default MapLegend
