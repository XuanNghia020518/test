<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #e9ecef;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .card {
            width: 100%;
            max-width: 600px;
            margin: 10px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-height: 80vh;
            overflow-y: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 26px;
            /* Tăng kích thước chữ tiêu đề */
        }

        h5 {
            color: #007bff;
            font-size: 20px;
            /* Tăng kích thước chữ */
            font-weight: bold;
            /* Làm chữ đậm hơn */
        }

        p {
            margin: 10px 0;
            color: #495057;
            font-size: 16px;
            /* Tăng kích thước chữ */
        }

        .no-data {
            color: #6c757d;
            font-style: italic;
            font-size: 16px;
            /* Đảm bảo kích thước chữ đồng nhất */
        }

        img {
            display: block;
            margin: 0 auto 20px;
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        hr {
            border: 1px solid #dee2e6;
            margin: 20px 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <div id="car-info-container" class="card p-4">
            <h1 class="text-center">Thông tin xe</h1>
            <div id="car-info-list"></div>

        </div>
    </div>

    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-app.js";
        import {
            getDatabase,
            ref,
            get
        } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-database.js";

        // Cấu hình Firebase
        const firebaseConfig = {
            apiKey: "AIzaSyAQpl6GOp8MDcuMTOMZQsU8G8DrKS69yEc",
            authDomain: "hit-monitor.firebaseapp.com",
            databaseURL: "https://hit-monitor-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "hit-monitor",
            storageBucket: "hit-monitor.appspot.com",
            messagingSenderId: "255063368541",
            appId: "1:255063368541:web:6fe516bf7b3af8a896beb4"
        };

        // Khởi tạo Firebase
        const app = initializeApp(firebaseConfig);
        const db = getDatabase();

        let carInfoContainer = document.getElementById('car-info-list');

        const SelectAllDataOnce = () => {
            const dbRef = ref(db, 'School/CarMaster');
            get(dbRef).then((snapshot) => {
                if (snapshot.exists()) {
                    const carData = snapshot.val();
                    console.log(carData);

                    Object.keys(carData).forEach((carKey) => {
                        const car = carData[carKey];
                        AddSingleRecord(
                            car.CarNumber,
                            car.CarDriver,
                            car.PhoneNo1,
                            car.CarLocation,
                            car.CarStatus?.FirstRun,
                            car.CarStatus?.LastRun,
                            car.SensorCount?.Sen1,
                            car.SensorCount?.Sen2,
                            car.SensorCount?.Sen3,
                            car.bit
                        );
                    });
                } else {
                    carInfoContainer.innerHTML = "<p class='no-data'>Không có dữ liệu</p>";
                }
            }).catch((error) => {
                console.error("Lỗi khi đọc dữ liệu:", error);
            });
        };

        const AddSingleRecord = (CarNumber, CarDriver, PhoneNo1, CarLocation, FirstRun, LastRun, Sen1, Sen2, Sen3, bit) => {
            let info = document.createElement('div');
            info.className = "mb-3";
            let statusText = "";
            let imgSrc = "";
            if (bit === 1) {
                statusText = "Xe đang hoạt động";
                imgSrc = "./images/image_go.png"; 
            } else if (bit === 2) {
                statusText = "Xe ngừng hoạt động"; 
                imgSrc = "./images/image_stop.png";
            } else {
                statusText = "Không rõ trạng thái";
            }

            info.innerHTML = `
                <h5 class="text-center">Biển số: ${CarNumber || "<span class='no-data'>N/A</span>"}</h5>
                <p class="text-center">Tài xế: ${CarDriver || "<span class='no-data'>N/A</span>"}</p>
                <p class="text-center">Số điện thoại tài xế: ${PhoneNo1 || "<span class='no-data'>N/A</span>"}</p>
                <p>Trạng thái xe:</p>
                <p><img src="${imgSrc}" width="100" height="100"></p>
                <p>Tọa độ xe: ${CarLocation || "<span class='no-data'>N/A</span>"}</p> </br>
                <p style="color: aquamarine">Chạy từ: ${FirstRun || "<span class='no-data'>N/A</span>"}</p>
                <p style="color: red">Dừng từ: ${LastRun || "<span class='no-data'>N/A</span>"}</p>
                <p class="text-center"><img src="./images/image_bus.png" hight="" width="390"></p>
                <p>Cảm biến 1: ${Sen1 !== undefined ? Sen1 : "<span class='no-data'></span>"}</p>
                <p>Cảm biến 2: ${Sen2 !== undefined ? Sen2 : "<span class='no-data'></span>"}</p>
                <p>Cảm biến 3: ${Sen3 !== undefined ? Sen3 : "<span class='no-data'></span>"}</p>
                <hr>
            `;

            carInfoContainer.appendChild(info);
        };

        SelectAllDataOnce();
    </script>
</body>

</html>