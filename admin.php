<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firebase Test</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        .table {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .table td {
            text-align: center;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #e9ecef;
        }

        .table-hover tbody tr:hover {
            background-color: #cce5ff;
        }

        .no-data {
            color: #6c757d;
        }

        .no-data-message {
            text-align: center;
            color: #dc3545;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Biển số</th>
                    <th>Tài xế</th>
                    <th>Số điện thoại</th>
                    <th>Theo dõi xe</th>
                    <th>Tọa độ xe</th>
                    <th>Chạy từ</th>
                    <th>Dừng từ</th>
                </tr>
            </thead>
            <tbody id="tbody1">
                <!-- Dữ liệu sẽ được chèn ở đây -->
            </tbody>
        </table>
        <div id="no-data-message" class="no-data-message" style="display:none;">Không có dữ liệu để hiển thị.</div>
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

        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyAQpl6GOp8MDcuMTOMZQsU8G8DrKS69yEc",
            authDomain: "hit-monitor.firebaseapp.com",
            databaseURL: "https://hit-monitor-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "hit-monitor",
            storageBucket: "hit-monitor.appspot.com",
            messagingSenderId: "255063368541",
            appId: "1:255063368541:web:6fe516bf7b3af8a896beb4"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const db = getDatabase();

        // Reference to tbody
        let tbody = document.getElementById('tbody1');
        let noDataMessage = document.getElementById('no-data-message');

        const SelectAllDataOnce = () => {
            const dbRef = ref(db, 'School/CarMaster');
            get(dbRef).then((snapshot) => {
                if (snapshot.exists()) {
                    const carData = snapshot.val();
                    console.log(carData);
                    let hasData = false;

                    Object.keys(carData).forEach((carKey) => {
                        const car = carData[carKey];
                        AddSingleRecord(
                            car.CarNumber,
                            car.CarDriver,
                            car.PhoneNo1,
                            car.SensorCount,
                            car.CarLocation,
                            car.CarStatus?.FirstRun,
                            car.CarStatus?.LastRun
                        );
                        hasData = true;
                    });

                    if (!hasData) {
                        noDataMessage.style.display = 'block';
                    }
                } else {
                    console.log("No data available");
                    noDataMessage.style.display = 'block';
                }
            }).catch((error) => {
                console.error("Error reading data:", error);
            });
        };

        const AddSingleRecord = (CarNumber, CarDriver, PhoneNo1, SensorStatus, CarLocation, FirstRun, LastRun) => {
            let trow = document.createElement('tr');
            let td1 = document.createElement('td');
            let td2 = document.createElement('td');
            let td3 = document.createElement('td');
            let td4 = document.createElement('td');
            let td5 = document.createElement('td');
            let td6 = document.createElement('td');
            let td7 = document.createElement('td');

            td1.innerHTML = CarNumber || "<span class='no-data'>N/A</span>";
            td2.innerHTML = CarDriver || "<span class='no-data'>N/A</span>";
            td3.innerHTML = PhoneNo1 || "<span class='no-data'>N/A</span>";
            td4.innerHTML = `Sen1: ${SensorStatus?.Sen1 !== undefined ? SensorStatus.Sen1 : "<span class='no-data'>N/A</span>"}, 
                Sen2: ${SensorStatus?.Sen2 !== undefined ? SensorStatus.Sen2 : "<span class='no-data'>N/A</span>"}, 
                Sen3: ${SensorStatus?.Sen3 !== undefined ? SensorStatus.Sen3 : "<span class='no-data'>N/A</span>"}`;
            td5.innerHTML = CarLocation || "<span class='no-data'>N/A</span>";
            td6.innerHTML = FirstRun || "<span class='no-data'>N/A</span>";
            td7.innerHTML = LastRun || "<span class='no-data'>N/A</span>";
            trow.append(td1, td2, td3, td4, td5, td6, td7);
            tbody.append(trow);
        };

        SelectAllDataOnce();
    </script>
</body>

</html>
