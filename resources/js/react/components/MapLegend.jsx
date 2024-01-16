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
                'Primary',
                'Secondary',
                'Tertiary',
                'Trunk',
                'Service',
                'Residential',
                'Living street',
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
                div.innerHTML += `<span><i style="background: ${colors[i]}"></i>${categories[i]}</span><br/>`
            }

            return div
        }

        roadLegend.addTo(map)

        // Heatmap legend
        const heatMapLegend = L.control({ position: 'topleft' })

        heatMapLegend.onAdd = function () {
            const div = L.DomUtil.create('div', 'legend-density')

            div.innerHTML += '<h4>Density</h4>'
            div.innerHTML += `<div id='density' style="background: linear-gradient(to left, #ff0000, #40ff00); height: 18px;"></div>`

            return div
        }

        heatMapLegend.addTo(map)

        //Interpolated legend
        const interpolatedLegend = L.control({ position: 'bottomright' })

        interpolatedLegend.onAdd = function () {
            const div = L.DomUtil.create('div', 'legend-interpolated')

            const rates = ['>90%', '>80%', '>70%', '>60%', '<60%']

            const colors = ['#219C90', '#A9C52F', '#FEC24A', '#FC9918', '#D83F31']

            div.innerHTML += '<h4>RPR</h4>'
            for (let i = 0; i < rates.length; i++) {
                div.innerHTML += `<i style="background: ${colors[i]}"></i><span>${rates[i]}</span><br>`
            }
            return div
        }

        interpolatedLegend.addTo(map)

        // Shop legend
        const shopLegend = L.control({ position: 'topleft' })

        shopLegend.onAdd = function () {
            const div = L.DomUtil.create('div', 'legend-shop')
            div.classList.add('flex')
            div.classList.add('items-center')
            div.innerHTML += `<img src="http://localhost:8000/images/vendor/leaflet/dist/marker-icon.png?2b3e1faf89f94a4835397e7a43b4f77d" style="width: 18px; display: inline-block;"><div class='ml-2'>Shop</div><br>`

            return div
        }

        shopLegend.addTo(map)
    }, [])

    return null
}

export default MapLegend
