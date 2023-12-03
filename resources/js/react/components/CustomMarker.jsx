import { useEffect } from 'react'
import { Marker, Popup, useMap } from 'react-leaflet'

export default function CustomMarker({ marker }) {
    const map = useMap()

    useEffect(() => {
        if (marker.isShow) {
            console.log(marker)
            map.flyTo([marker.x, marker.y], map.getZoom())
        }
    }, [marker.x])

    return (
        marker.isShow && (
            <Marker position={[marker.x, marker.y]}>
                <Popup>
                    A pretty CSS3 popup. <br /> Easily customizable.
                </Popup>
            </Marker>
        )
    )
}
