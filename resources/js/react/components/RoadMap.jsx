import '../../../css/style.css'

import { memo, useEffect, useState } from 'react'

import L from 'leaflet'
import { useMap } from 'react-leaflet'

function RoadMap({ roads, toggleLayer }) {
    const map = useMap()
    // const [roadLayer, setRoadLayer] = useState()

    const onEachFeature = (feature, layer) => {
        switch (feature.properties.type) {
            case 'primary':
            case 'primary_link':
                layer.options.color = '#9e7fa9'
                break

            case 'secondary':
            case 'secondary_link':
                layer.options.color = '#bba683'
                break

            case 'tertiary':
            case 'tertiary_link':
                layer.options.color = '#d5b78a'
                break

            case 'track':
            case 'trunk':
            case 'trunk_link':
                layer.options.color = '#cabaa2'
                break

            case 'service':
                layer.options.color = '#d0d63f'
                break

            case 'residential':
                layer.options.color = '#e388bf'
                break

            case 'road':
            case 'path':
            case 'steps':
            case 'living_street':
                layer.options.color = '#f5e9b7'
                break
        }
    }

    useEffect(() => {
        var legend = L.control({ position: 'bottomleft' })

        legend.onAdd = function (map) {
            var div = L.DomUtil.create('div', 'legend')

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
            for (var i = 0; i < categories.length; i++) {
                div.innerHTML += `<i style="background: ${colors[i]}"></i><span>${categories[i]}</span><br>`
            }

            return div
        }

        legend.addTo(map)
    }, [])

    // useEffect(() => {
    //     var overlayMaps = {
    //         Road: roadLayer,
    //     }
    //     var layerControl = L.control.layers(TileLayer, overlayMaps).addTo(map)
    // }, [roadLayer])

    useEffect(() => {
        var road = L.geoJSON(null, { onEachFeature: onEachFeature })
        road.addTo(map)
        road.addData(roads)
        // setRoadLayer(road)
    }, [roads])

    // useEffect(() => {
    //     if (toggleLayer) {
    //         L.map.removeLayer()
    //     } else {
    // map.addLayer(roadLayer)
    //     }
    // }, [toggleLayer])

    return null
}
export default memo(RoadMap)
