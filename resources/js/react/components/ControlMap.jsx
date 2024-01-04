import React, { useEffect } from 'react'

import L from 'leaflet'
import { useMap } from 'react-leaflet'

function ControlMap({ setHeatMapShow, setRoadShow, setShopShow }) {
    const map = useMap()

    useEffect(() => {
        const controlMap = L.control({ position: 'topright' })

        controlMap.onAdd = function () {
            const div = L.DomUtil.create('div', 'legend-control-map')

            div.innerHTML += '<h4>Layer</h4>'
            div.innerHTML += `<div> <input type="checkbox" id="shop" name="shop" checked/>
            <label for="shop"> Shop</label><br>
            <input type="checkbox" id="road" name="road" checked/>
            <label for="road"> Road</label><br>
            <input type="checkbox" id="heatmap" name="heatmap" checked/>
            <label for="heatmap"> Heatmap</label></div>`

            return div
        }

        controlMap.addTo(map)

        const road = document.getElementById('road')
        road.onclick = () => {
            const road = document.getElementsByTagName('g')[0]

            if (road.style.display === 'none') {
                road.style.display = 'block'
            } else {
                road.style.display = 'none'
            }

            const roadMapLegend = document.getElementsByClassName('legend-road-type')[0]
            if (roadMapLegend.style.display === 'none') {
                roadMapLegend.style.display = 'block'
            } else {
                roadMapLegend.style.display = 'none'
            }
        }

        const shop = document.getElementById('shop')
        shop.onclick = () => {
            setShopShow(shop.checked)
        }

        const heatMap = document.getElementById('heatmap')
        heatMap.onclick = () => {
            setHeatMapShow(heatMap.checked)

            const heatMapLegend = document.getElementsByClassName('legend-density')[0]
            if (heatMapLegend.style.display === 'none') {
                heatMapLegend.style.display = 'block'
            } else {
                heatMapLegend.style.display = 'none'
            }
        }
    }, [])
    return null
}

export default ControlMap
