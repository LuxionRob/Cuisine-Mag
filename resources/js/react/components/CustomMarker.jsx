import { useEffect } from 'react'
import { Marker, Popup, useMap } from 'react-leaflet'

export default function CustomMarker({ isShow, coordinates }) {
    const map = useMap()

    useEffect(() => {
        if (isShow) {
            map.flyTo(coordinates, map.getZoom(), { animate: false })
        }
    }, [coordinates])

    return (
        isShow && (
            <Marker position={coordinates}>
                <Popup>
                    A pretty CSS3 popup. <br /> Easily customizable.
                </Popup>
            </Marker>
        )
    )
}
