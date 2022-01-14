<?php
//session_start();
// connect to database
$db = mysqli_connect("localhost", "root", "", "todo");

// initialize variables
$errors = "";
$task = "";
//$id = 0;
$update = false;

// insert a quote if submit button is clicked
if (isset($_POST['submit'])) {
	if (empty($_POST['task'])) {
		$errors = "You must fill in the task";
	} else {
		$task = $_POST['task'];
		$sql = "INSERT INTO tasks (task) VALUES ('$task')";
		mysqli_query($db, $sql);
		header('location: index.php');
	}
}
// delete task
if (isset($_GET['del_task'])) {
	$id = $_GET['del_task'];
	mysqli_query($db, "DELETE FROM tasks WHERE id=$id");
	//$_SESSION['message'] = "Task deleted for Id:" . $id;
	header('location: index.php');
}
// edit task
if (isset($_GET['edit_task'])) {
	$id = $_GET['edit_task'];
	$update = true;
	$result = mysqli_query($db, "SELECT * FROM tasks WHERE id='$id'");
	$row = mysqli_fetch_assoc($result);
	$task = $row['task'];
}
// update the edited task
if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$task = $_POST['task'];
	mysqli_query($db, "UPDATE tasks SET task='$task' WHERE id='$id'");
	header('location: index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>ToDo List Application PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
	<div class="heading">
		<h2 style="font-style: 'Hervetica';">ToDo List Application PHP and MySQL database</h2>
	</div>
	<form method="post" action="index.php" class="input_form">
		<?php if (isset($errors)) { ?>
			<p><?php echo $errors; ?></p>
		<?php } ?>
		<input type="text" name="task" class="task_input">
		<?php
		if ($update == true) :
		?>
			<button type="submit" name="update" id="add_btn" class="add_btn">Update</button>
		<?php else : ?>
			<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
		<?php endif; ?>
	</form>
	<table>
		<thead>
			<tr>
				<th>S.No</th>
				<th>Tasks</th>
				<th colspan="2">Action</th>
			</tr>
		</thead>

		<tbody>
			<?php
			// select all tasks if page is visited or refreshed
			$tasks = mysqli_query($db, "SELECT * FROM tasks");

			$i = 1;
			while ($row = mysqli_fetch_array($tasks)) { ?>
				<tr>
					<td class="serialNumber"> <?php echo $i; ?> </td>
					<td class="task"> <?php echo $row['task']; ?> </td>
					<td class="edit_delete">
						<a href="index.php?edit_task=<?php echo $row['id'] ?>">Edit</a>

						<a href="index.php?del_task=<?php echo $row['id'] ?>">X</a>
					</td>
				</tr>
			<?php $i++;
			} ?>
		</tbody>
	</table>
</body>

</html>