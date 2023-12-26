import '../../../css/style.css'

import { memo, useEffect } from 'react'

import L from 'leaflet'
import { useMap } from 'react-leaflet'

function RoadMap({ roads }) {
    const map = useMap()

    var myStyle = {
        color: '#8d1812',
        weight: 5,
        opacity: 0.65,
    }

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

            case 'footway':
            case 'pedestrian':
                layer.options.color = '#83fdd8'
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

            case 'motorway':
            case 'motorway_link':
            case 'cycleway':
                layer.options.color = '#4d90fe'
                break

            case 'construction':
                layer.options.color = '#c42b1c'
                break

            case 'proposed':
                layer.options.color = '#60b79c'
                break

            case 'unclassified':
                layer.options.color = '#b2b2b2'
                break
        }
    }

    // var legend = L.control({ position: 'bottomleft' })
    // legend.onAdd = function (map) {
    //     const div = L.DomUtil.create('div', 'info legend')
    //     const labels = ['<strong>Categories</strong>']
    //     const categories = [
    //         'primary',
    //         'secondary',
    //         'tertiary',
    //         'trunk',
    //         'footway',
    //         'service',
    //         'residential',
    //         'living_street',
    //         'motorway',
    //         'construction',
    //         'proposed',
    //         'unclassified',
    //     ]

    //     const colors = [
    //         '#9e7fa9',
    //         '#bba683',
    //         '#d5b78a',
    //         '#cabaa2',
    //         '#83fdd8',
    //         '#d0d63f',
    //         '#e388bf',
    //         '#f5e9b7',
    //         '#4d90fe',
    //         '#c42b1c',
    //         '#60b79c',
    //         '#b2b2b2',
    //     ]

    //     for (var i = 0; i < categories.length; i++) {
    //         div.innerHTML += labels.push(
    //             '<i class="circle" style="background:' +
    //                 colors[i] +
    //                 '"></i> ' +
    //                 (categories[i] ? categories[i] : '+'),
    //         )
    //     }
    //     div.innerHTML = labels.join('<br>')
    //     return div
    // }
    // legend.addTo(map)

    useEffect(() => {
        var legend = L.control({ position: 'bottomleft' })

        legend.onAdd = function (map) {
            var div = L.DomUtil.create('div', 'legend')

            const categories = [
                'primary',
                'secondary',
                'tertiary',
                'trunk',
                'footway',
                'service',
                'residential',
                'living_street',
                'motorway',
                'construction',
                'proposed',
                'unclassified',
            ]

            const colors = [
                '#9e7fa9',
                '#bba683',
                '#d5b78a',
                '#cabaa2',
                '#83fdd8',
                '#d0d63f',
                '#e388bf',
                '#f5e9b7',
                '#4d90fe',
                '#c42b1c',
                '#60b79c',
                '#b2b2b2',
            ]

            div.innerHTML += '<h4>Road type</h4>'
            for (var i = 0; i < categories.length; i++) {
                div.innerHTML += `<i style="background: ${colors[i]}"></i><span>${categories[i]}</span><br>`
            }

            return div
        }

        legend.addTo(map)
    }, [])

    useEffect(() => {
        const road = L.geoJson(roads, { onEachFeature: onEachFeature }).addTo(map)
    }, [roads])

    return null
}
export default memo(RoadMap)
