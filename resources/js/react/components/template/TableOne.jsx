import { Link } from 'react-router-dom'
import { useState, useEffect } from 'react'
import { deleteUser, getAllUser } from '../../api/dashboard'

const TableOne = () => {
    const [user, setUser] = useState([])

    const handleDelete = id => {
        deleteUser(id).then(res => {
            setUser(user.filter(user => user.id != id))
        })
    }

    const fetchAllUsers = () => {
        getAllUser().then(res => setUser(res.data))
    }

    useEffect(() => {
        fetchAllUsers()
    }, [])

    return (
        <div className="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <h4 className="mb-6 text-xl font-semibold text-black dark:text-white">Users</h4>

            <div className="flex flex-col">
                <div className="bg-gray-2 grid grid-cols-3 rounded-sm dark:bg-meta-4 sm:grid-cols-5">
                    <div className="p-2.5 xl:p-5">
                        <h5 className="text-sm font-medium uppercase xsm:text-base">Name</h5>
                    </div>
                    <div className="p-2.5 text-center xl:p-5">
                        <h5 className="text-sm font-medium uppercase xsm:text-base">Email</h5>
                    </div>
                    <div className="p-2.5 text-center xl:p-5">
                        <h5 className="text-sm font-medium uppercase xsm:text-base">Role</h5>
                    </div>
                    <div className="hidden p-2.5 text-center sm:block xl:p-5">
                        <h5 className="text-sm font-medium uppercase xsm:text-base">Created at</h5>
                    </div>
                    <div className="hidden p-2.5 text-center sm:block xl:p-5">
                        <h5 className="text-sm font-medium uppercase xsm:text-base">Action</h5>
                    </div>
                </div>
                {user?.length > 0
                    ? user.map(i => (
                          <div
                              key={i.id + 'user'}
                              className="grid grid-cols-3 border-b border-stroke dark:border-strokedark sm:grid-cols-5"
                          >
                              <div className="flex items-center justify-center p-2.5 xl:p-5">
                                  <p className="text-black dark:text-white">
                                      <Link to={'/users/' + i.id}>{i.full_name}</Link>
                                  </p>
                              </div>

                              <div className="flex items-center justify-center p-2.5 xl:p-5">
                                  <p className="text-meta-3">
                                      <Link to={'/users/' + i.id}>{i.email}</Link>
                                  </p>
                              </div>

                              <div className="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                  <p className="text-black dark:text-white">{i.role}</p>
                              </div>

                              <div className="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                  <p className="text-meta-5">{i.created_at}</p>
                              </div>
                              <div className="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                  <Link to={'/users/' + i.id} className="button primary">
                                      Show
                                  </Link>
                                  <Link to={'/users/' + i.id + '/edit'} className="button edit">
                                      Edit
                                  </Link>
                                  <button
                                      onClick={e => handleDelete(i.id)}
                                      className="button delete"
                                  >
                                      Delete
                                  </button>
                              </div>
                          </div>
                      ))
                    : null}
            </div>
        </div>
    )
}

export default TableOne
