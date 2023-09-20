<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<?php 
		include 'config.php';
		include 'controller.php';
		$database = new database();
		$controller = new controller($database->con);
	?>
	<div class="container align-items-center justify-content-between">
		<h2 class="my-4">CREATE DATA</h2>
		<div class="py-2" style="width: 40%;">
		<form method="post" id="create_task" action="action.php?action=create">
			<div class="form-group">
				<label>Title</label>
				<input type="text" name="title" class="form-control">
			</div>
			<div class="form-group">
				<label>Description</label>
				<input type="text" name="description" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary">Save</button>
		</form>
		</div>

		<div class="py-4">
			<form class="form-inline" method="get" action="index.php">
				<div class="form-group mb-2 mx-sm-3">
				Search
				</div>
				<div class="form-group mb-2">
					<input type="text" placeholder="Title" class="form-control" name="searchTitle">
				</div>
				<div class="form-group mx-sm-3 mb-2">
					<select id="searchStatus" name="searchStatus" class="form-control">
						<option value="">...</option>
						<option value="Pending">Pending</option>
						<option value="In Progress">In Progress</option>
						<option value="Completed">Completed</option>
					</select>
				</div>
				<button type="submit" class="btn btn-primary mb-2">Search</button>
			</form>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>Title</th>
					<th>Description</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$no = 1;
					$searchTitle = isset($_GET['searchTitle']) ? $_GET['searchTitle'] : '';
					$searchStatus = isset($_GET['searchStatus']) ? $_GET['searchStatus'] : '';
					foreach($controller->getAll($searchTitle, $searchStatus) as $data){
				?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $data['title']; ?></td>
					<td><?php echo $data['description']; ?></td>
					<td><?php echo $data['status']; ?></td>
					<td style="width: 300px; " class="px-0; mx-0;">
						<div style="display: flex; align-items: center; ">
							<div style="width: 100%;" class="pr-sm-3">
								<input type="hidden" id="idEdit" value=<?php echo $data['id']; ?> />
								<select id="status" name="status" class="form-control">
									<option value="Pending" <?php if($data['status'] == 'Pending') echo "selected"; ?>>Pending</option>
									<option value="In Progress" <?php if($data['status'] == 'In Progress') echo "selected"; ?>>In Progress</option>
									<option value="Completed" <?php if($data['status'] == 'Completed') echo "selected"; ?>>Completed</option>
								</select>
							</div>
							<div style="width: 40%;">
								<a href="action.php?id=<?php echo $data['id']; ?>&action=delete">Delete</a>
							</div>
						</div>
					</td>
				</tr>
				<?php 
					}
				?>
			</tbody>
		</table>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js" ></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script type="text/javascript">
        $(document).ready(function() {

			$('#status').on('change', function() {
				let id = $('#idEdit').val();

                $.ajax({
                    url: 'action.php?action=update',
                    type: 'post',
                    data: $(this).serialize(),
					data: {
						id: id,
                        status: this.value
                    },
                    success: function(data) {
						window.location.href = 'index.php';
                    }
                });
			});

			$("#create_task").validate({
				rules: {
					title: "required",
					description: "required"
				},
				messages: {
					title: "Title must filled",
					description: "Description must filled"
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});


	</script>
</body>
</html>