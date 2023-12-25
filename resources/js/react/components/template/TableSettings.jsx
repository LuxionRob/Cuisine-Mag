import React from 'react'
import { BsFillTrashFill, BsFillPencilFill } from 'react-icons/bs'

const dataJSON = [{}]

export const Table = ({ rows, deleteRow, editRow }) => {
    const fields = Object.keys(Object.values(dataJSON)[0]).filter(
        item => !item.startsWith('delta_'),
    )

    return (
        <div className="table-wrapper max-w-full overflow-x-auto">
            <table className="table">
                <thead>
                    <tr className="bg-gray-2 text-left dark:bg-meta-4">
                        <th className="min-w-[220px] px-4 py-4 font-medium text-black xl:pl-11 dark:text-white">
                            Bond
                        </th>
                        <th className="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                            Paramter
                        </th>
                        <th className="px-4 py-4 font-medium text-black dark:text-white">
                            Criterion
                        </th>
                        <th className="px-4 py-4 font-medium text-black dark:text-white">
                            Value to give alert
                        </th>
                        <th className="px-4 py-4 font-medium text-black dark:text-white">
                            Alert type
                        </th>
                        <th className="px-4 py-4 font-medium text-black dark:text-white">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {rows.map((row, idx) => {
                        return (
                            <tr key={idx} className="content-center">
                                <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    {row.id}
                                </td>
                                <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <span className={`label label-${row.para}`}>{row.para}</span>
                                </td>

                                <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <span>
                                        {row.criterion == 0
                                            ? 'goes down by'
                                            : row.criterion == 1
                                              ? 'goes up by'
                                              : row.criterion == 2
                                                ? 'is smaller than'
                                                : row.criterion == 3
                                                  ? 'is greater than'
                                                  : 'is equal to'}
                                    </span>
                                </td>
                                <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    {row.value}
                                </td>
                                <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <span>
                                        {row.type == 0
                                            ? 'Info'
                                            : row.type == 1
                                              ? 'Warning'
                                              : 'Alert'}
                                    </span>
                                </td>

                                <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <span className="actions flex grid-cols-2 gap-4">
                                        <BsFillTrashFill
                                            className="delete-btn cursor-pointer"
                                            onClick={() => deleteRow(idx)}
                                        />

                                        <BsFillPencilFill
                                            className="edit-btn cursor-pointer"
                                            onClick={() => editRow(idx)}
                                        />
                                    </span>
                                </td>
                            </tr>
                        )
                    })}
                </tbody>
            </table>
        </div>
    )
}
