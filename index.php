<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<title>Coronavirus Spread </title>
	<style>
		.opacity-0 {
			opacity: 0.5;
		}

		.opacity-1 {
			opacity: 0.6;
		}

		.opacity-2 {
			opacity: 0.7;
		}

		.opacity-3 {
			opacity: 0.8;
		}

		.opacity-4 {
			opacity: 0.9;
		}

		#hideInMobile {
			display: none;
		}

		@media (min-width: 576px) {}

		/* Medium devices (tablets, 768px and up) */
		@media (min-width: 768px) {
			#hideInMobile {
				display: block;
			}
		}

		/* Large devices (desktops, 992px and up) */
		@media (min-width: 992px) {
			#hideInMobile {
				display: block;
			}
		}

		/* Extra large devices (large desktops, 1200px and up) */
		@media (min-width: 1200px) {
			#hideInMobile {
				display: block;
			}
		}
	</style>
</head>

<body class="d-flex flex-column h-100">
	<nav class="navbar navbar-dark bg-dark">
		<a class="navbar-brand" href="#">Coronavirus Spread in India</a>
	</nav>
	<!-- Pass JSON to JS from Server -->
	<div style="display: none" id="json">
		<?php echo file_get_contents("data.json"); ?>
	</div>
	<main role="main" class="flex-shrink-0">
		<div class="container-fluid">
			<div class="row my-4">
				<div class="my-1 col-md-3 col-lg-3">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<label class="input-group-text" for="states">State</label>
						</div>
						<select class="custom-select" id="states" autofocus onchange="changeState()">
							<option value="India">All</option>
							<option value="Andhra Pradesh">Andhra Pradesh</option>
							<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
							<option value="Arunachal Pradesh">Arunachal Pradesh</option>
							<option value="Assam">Assam</option>
							<option value="Bihar">Bihar</option>
							<option value="Chandigarh">Chandigarh</option>
							<option value="Chhattisgarh">Chhattisgarh</option>
							<option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
							<option value="Daman and Diu">Daman and Diu</option>
							<option value="Delhi">Delhi</option>
							<option value="Lakshadweep">Lakshadweep</option>
							<option value="Puducherry">Puducherry</option>
							<option value="Goa">Goa</option>
							<option value="Gujarat">Gujarat</option>
							<option value="Haryana">Haryana</option>
							<option value="Himachal Pradesh">Himachal Pradesh</option>
							<option value="Jammu and Kashmir">Jammu and Kashmir</option>
							<option value="Jharkhand">Jharkhand</option>
							<option value="Karnataka">Karnataka</option>
							<option value="Kerala">Kerala</option>
							<option value="Madhya Pradesh">Madhya Pradesh</option>
							<option value="Maharashtra">Maharashtra</option>
							<option value="Manipur">Manipur</option>
							<option value="Meghalaya">Meghalaya</option>
							<option value="Mizoram">Mizoram</option>
							<option value="Nagaland">Nagaland</option>
							<option value="Odisha">Odisha</option>
							<option value="Punjab">Punjab</option>
							<option value="Rajasthan">Rajasthan</option>
							<option value="Sikkim">Sikkim</option>
							<option value="Tamil Nadu">Tamil Nadu</option>
							<option value="Telangana">Telangana</option>
							<option value="Tripura">Tripura</option>
							<option value="Uttar Pradesh">Uttar Pradesh</option>
							<option value="Uttarakhand">Uttarakhand</option>
							<option value="West Bengal">West Bengal</option>
						</select>
					</div>
				</div>
				<div class="my-1 col-md-3 col-lg-3 ">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<label class="input-group-text" for="typeOfChart">Chart Type</label>
						</div>
						<select class="custom-select" id="typeOfChart" onchange="changeType()">
							<option value="doughnut" selected>Doughnut</option>
							<option value="pie">Pie</option>
							<option value="bar">Bar</option>
							<option value="column">Column</option>
						</select>
					</div>
				</div>
				<div class="my-1 col-md-3 col-lg-3" id="hideInMobile">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<label class="input-group-text" for="chartTheme">Chart Theme</label>
						</div>
						<select class="custom-select" id="chartTheme" onchange="changeTheme()">
							<option value="BootStrap" selected>Bootstrap</option> 
							<option value="light1">Light 1</option>
							<option value="light2">Light 2</option>
							<option value="dark1">Dark 1</option>
							<option value="dark2">Dark 2</option>
						</select>
					</div>
				</div>
				<div class="my-1 col-md-3 col-lg-3 " id="hideInMobile">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<label class="input-group-text" for="dataSource">Data Source</label>
						</div>
						<select class="custom-select" id="dataSource" disabled="true">
							<option value="mohfw" selected>MOHFW, GoI</option>
							<option value="who">WHO</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row my-4">
				<div class="col-md-6 col-lg-5 ">
					<div id="canvas" class="  mb-4" style="height: 50vh;"></div>
				</div>
				<div class="col-md-6 col-lg-7 mb-4">
					<div class="container-fluid mb-4">
						<div class="row">
							<div class="col-md-6 col-lg-6 mt-2">
								<div class="card shadow mb-2 bg-info text-white border-info">
									<div class="card-body">
										<h5 class="card-title display-4" id="indianCases">0</h5>
										<h6 class="card-subtitle mb-2" id="regionName1">Total Cases in</h6>
										<div class="text-white opacity-4">Indian Nationals</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 mt-2">
								<div class="card shadow-lg mb-2 bg-secondary text-white border-secondary">
									<div class="card-body">
										<h5 class="card-title display-4" id="foreignCases">0</h5>
										<h6 class="card-subtitle mb-2" id="regionName2">Total Cases in</h6>
										<div class="text-white">Foreign Nationals</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 mt-2">
								<div class="card shadow mb-2 bg-success text-white border-success">
									<div class="card-body">
										<h5 class="card-title display-4" id="cured">0</h5>
										<h6 class="card-subtitle mb-2" id="curedPercentage">Recovery</h6>
										<div class="text-white opacity-4">Recovered, Discharged or Migrated</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 mt-2">
								<div class="card shadow mb-2 bg-danger text-white border-danger">
									<div class="card-body">
										<h5 class="card-title display-4" id="deaths">0</h5>
										<h6 class="card-subtitle mb-2" id="fatalPercentage">Fatality</h6>
										<div class="text-white opacity-4">Total Confirmed Deaths</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	</main>

	<footer class="footer bg-dark text-white fixed-bottom mt-auto py-2">
		<div class="container">
			<span class="opacity-2">Last Updated: <?php echo file_get_contents("lastUpdated.txt") ?> from mohfw.gov.in</span>
			<span class="text-muted" style="float:right" ></span>
		</div>
	</footer>

	<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script src="main.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>

</html>