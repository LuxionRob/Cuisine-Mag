import React, { useEffect } from 'react'

import L from 'leaflet'
import { useMap } from 'react-leaflet'

function ControlMap({ setHeatMapShow, setRoadShow, setShopShow, setInterpolateShow }) {
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
            <label for="heatmap">Population Density</label><br>
            <input type="checkbox" id="interpolate" name="interpolate" checked/>
            <label for="interpolate">Repeat Purchase Rate (RPR)</label></div>`

            return div
        }
        controlMap.addTo(map)

        const road = document.getElementById('road')
        road.onclick = () => {
            setRoadShow(road.checked)
            // const g = document.getElementsByTagName('g')[0]

            // if (g.style.display === 'none') {
            //     g.style.display = 'block'
            // } else {
            //     g.style.display = 'none'
            // }

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

            const shopLegend = document.getElementsByClassName('legend-shop')[0]
            if (shopLegend.style.display === 'none') {
                shopLegend.style.display = 'flex'
            } else {
                shopLegend.style.display = 'none'
            }
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

        const interpolate = document.getElementById('interpolate')
        interpolate.onclick = () => {
            setInterpolateShow(interpolate.checked)

            const interpolatedLegend = document.getElementsByClassName('legend-interpolated')[0]
            if (interpolatedLegend.style.display === 'none') {
                interpolatedLegend.style.display = 'block'
            } else {
                interpolatedLegend.style.display = 'none'
            }
        }
    }, [])
    return null
}

export default ControlMap
