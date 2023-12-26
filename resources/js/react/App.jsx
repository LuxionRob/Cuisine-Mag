import { Suspense, lazy, useEffect, useState } from 'react'
import { Route, Routes } from 'react-router-dom'
import { Toaster } from 'react-hot-toast'
import { BrowserRouter as Router } from 'react-router-dom'

import ECommerce from './pages/Dashboard/ECommerce.jsx'
import Loader from './common/Loader'
import User from './pages/User.jsx'
import UserDetail from './pages/UserDetail.jsx'

const DefaultLayout = lazy(() => import('./layout/DefaultLayout.jsx'))

function App() {
    const [loading, setLoading] = useState(true)

    useEffect(() => {
        setTimeout(() => setLoading(false), 1000)
    }, [])

    return loading ? (
        <Loader />
    ) : (
        <>
            <Router basename="dashboard">
                <Toaster
                    position="top-right"
                    reverseOrder={false}
                    containerClassName="overflow-auto"
                />
                <Routes>
                    <Route element={<DefaultLayout />}>
                        <Route index element={<ECommerce />} />
                        <Route path="users" element={<User />}></Route>
                        <Route path="users/:id" element={<UserDetail />}></Route>
                    </Route>
                </Routes>
            </Router>
        </>
    )
}

export default App
