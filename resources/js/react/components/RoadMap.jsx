import { memo, useEffect, useState } from 'react'

import L from 'leaflet'
import { useMap } from 'react-leaflet'

function RoadMap({ roads }) {
    const map = useMap()

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
        L.geoJSON(roads, { onEachFeature: onEachFeature }).addTo(map)
    }, [roads])

    return null
}
export default memo(RoadMap)
