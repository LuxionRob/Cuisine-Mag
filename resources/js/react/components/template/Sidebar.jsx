import React, { useEffect, useRef, useState } from 'react'
import { NavLink, useLocation } from 'react-router-dom'
import SidebarLinkGroup from './SidebarLinkGroup'
import { FaUser } from 'react-icons/fa'
import { CiViewBoard } from 'react-icons/ci'

const Sidebar = ({ sidebarOpen, setSidebarOpen }) => {
    const location = useLocation()
    const { pathname } = location

    const trigger = useRef(null)
    const sidebar = useRef(null)

    const storedSidebarExpanded = localStorage.getItem('sidebar-expanded')
    const [sidebarExpanded, setSidebarExpanded] = useState(
        storedSidebarExpanded === null ? false : storedSidebarExpanded === 'true',
    )

    // close on click outside
    useEffect(() => {
        const clickHandler = ({ target }) => {
            if (!sidebar.current || !trigger.current) return
            if (
                !sidebarOpen ||
                sidebar.current.contains(target) ||
                trigger.current.contains(target)
            )
                return
            setSidebarOpen(false)
        }
        document.addEventListener('click', clickHandler)
        return () => document.removeEventListener('click', clickHandler)
    })

    // close if the esc key is pressed
    useEffect(() => {
        const keyHandler = ({ keyCode }) => {
            if (!sidebarOpen || keyCode !== 27) return
            setSidebarOpen(false)
        }
        document.addEventListener('keydown', keyHandler)
        return () => document.removeEventListener('keydown', keyHandler)
    })

    useEffect(() => {
        localStorage.setItem('sidebar-expanded', sidebarExpanded.toString())
        if (sidebarExpanded) {
            document.querySelector('body')?.classList.add('sidebar-expanded')
        } else {
            document.querySelector('body')?.classList.remove('sidebar-expanded')
        }
    }, [sidebarExpanded])

    return (
        <aside
            ref={sidebar}
            className={`absolute left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-white duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0 ${
                sidebarOpen ? 'translate-x-0' : '-translate-x-full'
            }`}
        >
            <div className="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
                {/* <!-- Sidebar Menu --> */}
                <nav className="mt-5 px-4 py-4 lg:mt-9 lg:px-6">
                    {/* <!-- Menu Group --> */}
                    <div>
                        <h3 className="mb-4 ml-4 text-sm font-semibold text-black-2">MENU</h3>

                        <ul className="mb-6 flex flex-col gap-1.5">
                            <li>
                                <NavLink
                                    to="/"
                                    className={`group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-black-2 duration-300 ease-in-out hover:bg-gray-200${
                                        pathname == '/dashboard' && 'bg-gray-300'
                                    }`}
                                >
                                    <CiViewBoard />
                                    Dashboard
                                </NavLink>
                            </li>
                            <li>
                                <NavLink
                                    to="/users"
                                    className={`group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-black-2 duration-300 ease-in-out hover:bg-gray-200${
                                        pathname.includes('users') && 'bg-gray-300'
                                    }`}
                                >
                                    <FaUser />
                                    User
                                </NavLink>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </aside>
    )
}

export default Sidebar
