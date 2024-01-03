import { useEffect } from 'react'
import { useMap } from 'react-leaflet'

export default function MapContextMenu() {
    const map = useMap()

    useEffect(() => {
        map.addEventListener('contextmenu', e => {
            const string = `<a class="button primary !text-white" href='http://localhost:8000/users/create?role=salesman&lat=${e.latlng.lat}&lng=${e.latlng.lng}'>Create store with salesman</a>`
            console.log(string)
            const popup = L.popup().setLatLng(e.latlng).setContent(string)
            popup.openOn(map)
        })
        return () => {
            map.removeEventListener('contextmenu')
        }
    }, [])

    return null
}
