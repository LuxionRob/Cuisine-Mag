import { MapContainer, Marker, TileLayer } from 'react-leaflet'
import { getStores } from '../api/analyzeMap'
import { useEffect, useState } from 'react'

export default function AnalyzeMapPage() {
    const position = [10, 106]
    const [stores, setStores] = useState([])

    const fetchStores = async () => {
        try {
            const res = await getStores()
            setStores(res.data)
            console.log(res.data)
            return res
        } catch (error) {}
    }

    useEffect(() => {
        fetchStores()
    }, [])

    return (
        <MapContainer center={position} zoom={13} scrollWheelZoom={true} className="h-96 w-full">
            <TileLayer
                attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            />
            {stores.map(store => (
                <Marker position={[store.x, store.y]}></Marker>
            ))}
        </MapContainer>
    )
}
