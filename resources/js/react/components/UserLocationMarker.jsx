import React, { useState, useEffect } from 'react'
import { useMap, Marker, Popup } from 'react-leaflet'

export default function UserLocationMarker() {
    const [position, setPosition] = useState(null)
    const [positionString, setPositionString] = useState('')
    const [bbox, setBbox] = useState([])

    const map = useMap()

    useEffect(() => {
        map.locate().on('locationfound', function (e) {
            setPositionString(JSON.stringify({ x: e.latitude, y: e.longitude }))
            setPosition(e.latlng)
            map.flyTo(e.latlng, map.getZoom())
            const radius = e.accuracy
            const circle = L.circle(e.latlng, radius)
            circle.addTo(map)
            setBbox(e.bounds.toBBoxString().split(','))
        })
    }, [map])

    return position === null ? null : (
        <Marker position={position}>
            <input type="hidden" name="location" value={positionString} />
            <Popup>
                You are here. <br />
                Map bbox: <br />
                <b>Southwest lng</b>: {bbox[0]} <br />
                <b>Southwest lat</b>: {bbox[1]} <br />
                <b>Northeast lng</b>: {bbox[2]} <br />
                <b>Northeast lat</b>: {bbox[3]}
            </Popup>
        </Marker>
    )
}
