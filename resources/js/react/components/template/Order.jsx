import { useState, useEffect } from 'react'
import { getOrderWithStatus, updateOrderStatus } from '../../api/dashboard'

const Order = () => {
    const [order, setOrder] = useState([])
    const [status, setStatus] = useState('ALL')
    useEffect(() => {
        const fetchData = () => {
            getOrderWithStatus(status).then(res => setOrder(res.data.data))
        }
        fetchData()
    }, [status])

    const tinhTongSoLuong = danhSachDonDatHang => {
        if (!Array.isArray(danhSachDonDatHang)) {
            throw new Error('Đầu vào phải là một mảng các đơn đặt hàng.')
        }

        const tongSoLuong = danhSachDonDatHang.reduce((tong, donDatHang) => {
            if (donDatHang.hasOwnProperty('quantity')) {
                return tong + donDatHang.quantity
            } else {
                console.warn('Thiếu thuộc tính "quantity" trong một đơn đặt hàng. Bỏ qua.')
                return tong
            }
        }, 0) // Bắt đầu với giá trị khởi tạo là 0

        return tongSoLuong
    }
    const tinhTongGiaTri = mangDonDatHang => {
        if (!Array.isArray(mangDonDatHang)) {
            throw new Error('Đầu vào phải là một mảng các đơn đặt hàng.')
        }

        const tongGiaTri = mangDonDatHang.reduce((tong, donDatHang) => {
            if (donDatHang.hasOwnProperty('quantity') && donDatHang.hasOwnProperty('product')) {
                if (donDatHang.product.hasOwnProperty('price')) {
                    return tong + donDatHang.quantity * donDatHang.product.price
                } else {
                    console.warn(
                        'Thiếu thuộc tính "price" trong đối tượng "product". Bỏ qua đơn đặt hàng.',
                    )
                    return tong
                }
            } else {
                console.warn(
                    'Thiếu thuộc tính "quantity" hoặc "product" trong đơn đặt hàng. Bỏ qua.',
                )
                return tong
            }
        }, 0)
        return parseFloat(tongGiaTri.toFixed(2))
    }
    function formatDateTime(dateTime) {
        const hours = dateTime.getHours()
        const minutes = dateTime.getMinutes()
        const day = dateTime.getDate()
        const month = dateTime.getMonth() + 1 // Tháng trong JavaScript bắt đầu từ 0
        const year = dateTime.getFullYear()

        // Chuyển đổi thành định dạng "giờ ngày tháng năm"
        const formattedString = `${hours}:${minutes} ${day}/${month}/${year}`

        return formattedString
    }
    const handleOnClick = (id, status) => {
        console.log(id, status)

        updateOrderStatus(id, status).then(res => {
            setOrder(order.filter(o => o.id != id))
        })
    }

    return (
        <div className="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <div className="flex items-center justify-between">
                <h4 className="mb-6 text-xl font-semibold text-black dark:text-white">
                    Recent Orders
                </h4>
                <select
                    className="relative z-20 inline-flex appearance-none bg-transparent py-1 pl-3 pr-8 text-sm font-medium outline-none"
                    onChange={e => setStatus(e.target.value)}
                    value={status}
                >
                    <option value="ALL">All</option>
                    <option value="WAITING">Waiting</option>
                    <option value="PACKAGING">Packaging</option>
                    <option value="PACKAGED">Packaged</option>
                    <option value="DELIVERING">Delivering</option>
                    <option value="DELIVERED">Delivered</option>
                    <option value="CANCELED">Canceled</option>
                </select>
            </div>

            <div className="flex flex-col">
                <div className="bg-gray-2 grid grid-cols-3 rounded-sm dark:bg-meta-4 sm:grid-cols-6">
                    <div className="p-2.5 text-center xl:p-5">
                        <h5 className="text-sm font-medium uppercase xsm:text-base">Mã</h5>
                    </div>
                    <div className="p-2.5 text-center xl:p-5">
                        <h5 className="text-sm font-medium uppercase xsm:text-base">Số lượng</h5>
                    </div>
                    <div className="p-2.5 text-center xl:p-5">
                        <h5 className="text-sm font-medium uppercase xsm:text-base">Đơn giá</h5>
                    </div>
                    <div className="hidden p-2.5 text-center sm:block xl:p-5">
                        <h5 className="text-sm font-medium uppercase xsm:text-base">
                            Phương thức thanh toán
                        </h5>
                    </div>
                    <div className="hidden p-2.5 text-center sm:block xl:p-5">
                        <h5 className="text-sm font-medium uppercase xsm:text-base">Tạo ngày</h5>
                    </div>
                    <div className="hidden p-2.5 text-center sm:block xl:p-5">
                        <h5 className="text-sm font-medium uppercase xsm:text-base">Action</h5>
                    </div>
                </div>
                {order != null
                    ? order.map(i => (
                          <div
                              key={i.id + 'order'}
                              className="grid grid-cols-3 border-b border-stroke dark:border-strokedark sm:grid-cols-6"
                          >
                              <div className="flex items-center justify-center p-2.5 xl:p-5">
                                  <p className="text-black dark:text-white">
                                      <a href={'/orders/' + i.id}>{i.id}</a>
                                  </p>
                              </div>

                              <div className="flex items-center justify-center p-2.5 xl:p-5">
                                  <p className="text-meta-3">
                                      <a href={'/orders/' + i.id}>
                                          {tinhTongSoLuong(i.order_items)}
                                      </a>
                                  </p>
                              </div>
                              <div className="flex items-center justify-center p-2.5 xl:p-5">
                                  <p className="text-meta-3">
                                      <a href={'/orders/' + i.id}>
                                          {tinhTongGiaTri(i.order_items)}
                                      </a>
                                  </p>
                              </div>

                              <div className="flex items-center justify-center p-2.5 xl:p-5">
                                  <p className="text-meta-3">
                                      <a href={'/orders/' + i.id}>
                                          {i.order_items[0].payment_method}
                                      </a>
                                  </p>
                              </div>
                              <div className="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                  <p className="text-meta-5">{i.created_at}</p>
                              </div>
                              <div className="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                  {i.order_items[0].status === 'WAITING' && (
                                      <button
                                          className="button primary mr-1 text-center"
                                          onClick={() => handleOnClick(i.id, 'PACKAGING')}
                                      >
                                          Xác nhận
                                      </button>
                                  )}
                                  {['WAITING', 'PACKAGING', 'PACKAGED'].indexOf(
                                      i.order_items[0].status,
                                  ) >= 0 ? (
                                      <button
                                          className="button delete text-center"
                                          onClick={() => handleOnClick(i.id, 'CANCELED')}
                                      >
                                          Huỷ đơn
                                      </button>
                                  ) : null}
                              </div>
                          </div>
                      ))
                    : null}
            </div>
        </div>
    )
}

export default Order
