import { useState, useEffect } from 'react'
import { Link, useParams } from 'react-router-dom'
import { getUserById } from '../api/dashboard'

export default function UserDetail() {
    const [user, setUser] = useState({})
    const { id } = useParams()

    const fetchUser = () => {
        console.log(id)
        getUserById(id).then(res => {
            console.log(res.data)
            setUser(res.data)
        })
    }

    useEffect(() => {
        fetchUser()
    }, [])
    console.log(user.username)

    return user?.id != undefined ? (
        <div className="w-full p-6">
            <div className="mx-auto max-w-7xl bg-white shadow-sm sm:rounded-lg sm:px-6 lg:px-8">
                <div className="flex w-full justify-start border-b border-gray-200">
                    <div className=" bg-white p-6 ">
                        <p className="group relative ">
                            <strong>Username:</strong>
                            <span>{user.username}</span>
                        </p>
                        <p className="">
                            <strong>Fullname:</strong>
                            <span> {user.full_name}</span>
                        </p>
                        <p className="">
                            <strong>Email:</strong>
                            <span> {user.email}</span>
                        </p>
                    </div>
                    <div className="p-6 ">
                        <div className="flex items-center">
                            <select className="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:border-gray-300 hover:text-gray-700 focus:border-gray-300 focus:text-gray-700 focus:outline-none">
                                <div className="ml-1">
                                    <svg
                                        className="h-4 w-4 fill-current"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                                <div>Contacts</div>
                                {user.contacts.map(contact => (
                                    <option value={contact.id} key={contact.id + 'contact'}>
                                        <div>
                                            <strong>Name</strong>: {contact.name}
                                        </div>
                                        <div>
                                            <strong>Phone number</strong>: {contact.phone_number}
                                        </div>
                                        <div>
                                            <strong>Address </strong>: {contact.location.detail}
                                        </div>
                                    </option>
                                ))}
                            </select>

                            <div className="ml-2 hover:opacity-60 active:opacity-80">
                                <a href="{ route('contacts.create }">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        x="0px"
                                        y="0px"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 50 50"
                                    >
                                        <path d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="mt-4 flex justify-end pb-4">
                    <Link to={'/users/'} className="button edit mr-2">
                        Edit
                    </Link>
                </div>
            </div>
        </div>
    ) : null
}
