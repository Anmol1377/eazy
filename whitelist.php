<?php
include_once    'ezy_sc_sub_module.php';
//  ;
if (!defined('ABSPATH')) {
    die('Page not found');
}

$active = $active2 = '';
$show   = $show2 = '';

if (isset($_POST['add-ip']) OR isset($_GET['edit-id']) OR isset($_POST['edit-ip']) OR isset($_GET['delete-id'])) {
    $active = 'active';
    $show   = 'show ';
} else if (isset($_POST['add-file']) OR isset($_GET['edit-fid']) OR isset($_POST['edit-file']) OR isset($_GET['delete-fid'])) {
    $active2 = 'active';
    $show2   = 'show ';
} else {
    $active = 'active';
    $show   = 'show ';
}

$table = $wpdb->prefix . 'wpg_ipwhitelist';
$tablef = $wpdb->prefix . 'wpg_filewhitelist';

if (isset($_GET['delete-id'])) {
    $id = (int) $_GET["delete-id"];
    
    $wpdb->delete($table, array(
        'id' => $id
    ));
}

if (isset($_GET['delete-fid'])) {
    $id = (int) $_GET["delete-fid"];
    
    $wpdb->delete($tablef, array(
        'id' => $id
    ));
}

if (isset($_POST['add-ip'])) {
    $ip    = sanitize_text_field($_POST['ip']);
    $notes = sanitize_text_field($_POST['notes']);
    
    $validator = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM `$table` WHERE `ip` = %s LIMIT 1", $ip));
    if ($validator > 0) {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> ' . balanceTags("This <strong>IP Address</strong> is already whitelisted.", "ezy_sc-text") . '</p>
        </div>';
    } else {
        $wpdb->insert($table, array(
            'ip' => $ip,
            'notes' => $notes
        ), array(
            '%s',
            '%s'
        ));
    }
}

if (isset($_POST['add-file'])) {
    $path  = sanitize_text_field($_POST['path']);
    $notes = sanitize_text_field($_POST['notes']);
    
    $validator = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM `$tablef` WHERE `path` = %s LIMIT 1", $path));
    if ($validator > 0) {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> ' . balanceTags("This <strong>File / Path</strong> is already whitelisted.", "ezy_sc-text") . '</p>
        </div>';
    } else {
        $wpdb->insert($tablef, array(
            'path' => $path,
            'notes' => $notes
        ), array(
            '%s',
            '%s'
        ));
    }
}
?>
<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link <?php
echo esc_html($active);
?>" id="ipwhitelist-tab" data-toggle="tab" href="#ipwhitelist" role="tab" aria-controls="sqliprotection" aria-selected="true"><i class="fas fa-user"></i> <?php
echo esc_html__("IP Whitelist", "ezy_sc-text");
?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php
echo esc_html($active2);
?>" id="filewhitelist-tab" data-toggle="tab" href="#filewhitelist" role="tab" aria-controls="badbotsprotection" aria-selected="false"><i class="far fa-file-alt"></i> <?php
echo esc_html__("File Whitelist", "ezy_sc-text");
?></a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane <?php
echo esc_html($show) . ' ' . esc_html($active);
?>" id="ipwhitelist" role="tabpanel" aria-labelledby="ipwhitelist-tab">
<div class="row">
                    
				<div class="col-md-9">
<?php
if (isset($_GET['edit-id'])) {
    $id = (int) $_GET["edit-id"];
    
    $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM `$table` WHERE `id` = %d LIMIT 1", $id));
    
	if (empty($id) || $result == 0) {
        echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-whitelist">';
        exit();
    }
    
    $srow = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d LIMIT 1", $id));
    
    if (isset($_POST['edit-ip'])) {
        $ip    = sanitize_text_field($_POST['ip']);
        $notes = sanitize_text_field($_POST['notes']);
        
        $data_update = array(
            'ip' => $ip,
            'notes' => $notes
        );
        $data_where  = array(
            'id' => $id
        );
        $wpdb->update($table, $data_update, $data_where);
        
        //echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-whitelist">';
    }
?>         
<form class="form-horizontal" action="" method="post">
                    <div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
    echo esc_html__("Edit IP Address", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
                               <div class="form-group">
											<label class="control-label"><?php
    echo esc_html__("IP Address", "ezy_sc-text");
?>: </label>
											<div class="col-sm-12">
												<input type="text" name="ip" class="form-control" value="<?php
    echo esc_html($srow->ip);
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="control-label"><?php
    echo esc_html__("Notes", "ezy_sc-text");
?>: </label>
											<div class="col-sm-12">
												<textarea rows="4" name="notes" class="form-control" placeholder="<?php
    echo esc_html__("Additional (descriptive) information can be added here", "ezy_sc-text");
?>"><?php
    echo esc_html($srow->notes);
?></textarea>
											</div>
								</div>	
                        </div>
                        <div class="card-footer">
							<button class="btn btn-flat btn-success" name="edit-ip" type="submit"><?php
    echo esc_html__("Save", "ezy_sc-text");
?></button>
							<button type="reset" class="btn btn-flat btn-default"><?php
    echo esc_html__("Reset", "ezy_sc-text");
?></button>
				        </div>
                     </div>
				</form>
<?php
}
?>
				    <div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("IP Whitelist", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
<table id="dt-basic" class="table table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th><i class="fas fa-user"></i> <?php
echo esc_html__("IP Address", "ezy_sc-text");
?></th>
											<th><i class="fas fa-clipboard"></i> <?php
echo esc_html__("Notes", "ezy_sc-text");
?></th>
											<th><i class="fas fa-cog"></i> <?php
echo esc_html__("Actions", "ezy_sc-text");
?></th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $wpdb->get_results("SELECT * FROM `$table`");
foreach ($query as $row) {
    echo '
										<tr>
						                    <td>' . esc_html($row->ip) . '</td>
											<td>' . esc_html($row->notes) . '</td>
											<td>
                                            <a href="admin.php?page=ezy_sc-whitelist&edit-id=' . esc_html($row->id) . '" class="btn btn-flat btn-warning"><i class="fas fa-edit"></i> ' . esc_html__("Edit", "ezy_sc-text") . '</a>
                                            <a href="admin.php?page=ezy_sc-whitelist&delete-id=' . esc_html($row->id) . '" class="btn btn-flat btn-danger"><i class="fas fa-trash"></i> ' . esc_html__("Delete", "ezy_sc-text") . '</a>
											</td>
										</tr>
';
}
?>
									</tbody>
								</table>
                        </div>
                     </div>
                </div>

				<div class="col-md-3">
				     <div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Add IP Adress", "ezy_sc-text");
?></h3>
						</div>
				        <div class="card-body">
<form class="form-horizontal" action="" method="post">
                                <div class="form-group">
											<label class="control-label"><?php
echo esc_html__("IP Address", "ezy_sc-text");
?>: </label>
											<div class="col-sm-12">
												<input type="text" name="ip" class="form-control" required>
											</div>
							    </div>
								<div class="form-group">
											<label class="control-label"><?php
echo esc_html__("Notes", "ezy_sc-text");
?>: </label>
											<div class="col-sm-12">
												<textarea rows="5" name="notes" class="form-control" placeholder="<?php
echo esc_html__("Additional (descriptive) information can be added here", "ezy_sc-text");
?>"></textarea>
											</div>
								</div>	
                        </div>
                        <div class="card-footer">
							<button class="btn btn-flat btn-primary btn-block" name="add-ip" type="submit"><?php
echo esc_html__("Add", "ezy_sc-text");
?></button>
				        </div>
				     </div>
				</div>
</form>            
</div>

</div>
<div class="tab-pane <?php
echo esc_html($show2) . ' ' . esc_html($active2);
?>" id="filewhitelist" role="tabpanel" aria-labelledby="filewhitelist-tab">

<div class="row">
                    
				<div class="col-md-9">
<?php
if (isset($_GET['edit-fid'])) {
    $id = (int) $_GET["edit-fid"];
    
    $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM `$tablef` WHERE `id` = %d LIMIT 1", $id));
    
	if (empty($id) || $result == 0) {
        echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-whitelist">';
        exit();
    }
    
    $srow = $wpdb->get_row($wpdb->prepare("SELECT * FROM $tablef WHERE id = %d LIMIT 1", $id));
    
    if (isset($_POST['edit-file'])) {
        $path    = sanitize_text_field($_POST['path']);
        $notes = sanitize_text_field($_POST['notes']);
        
        $data_update = array(
            'path' => $path,
            'notes' => $notes
        );
        $data_where  = array(
            'id' => $id
        );
        $wpdb->update($tablef, $data_update, $data_where);
        
        //echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-whitelist">';
    }
?>         
<form class="form-horizontal" action="" method="post">
                    <div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
    echo esc_html__("Edit File", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
                               <div class="form-group">
											<label class="control-label"><?php
    echo esc_html__("File's Path", "ezy_sc-text");
?>: </label>
											<div class="col-sm-12">
												<input type="text" name="path" class="form-control" value="<?php
    echo esc_html($srow->path);
?>" required>
											</div>
								</div>
								<div class="form-group">
											<label class="control-label"><?php
    echo esc_html__("Notes", "ezy_sc-text");
?>: </label>
											<div class="col-sm-12">
												<textarea rows="4" name="notes" class="form-control" placeholder="<?php
    echo esc_html__("Additional (descriptive) information can be added here", "ezy_sc-text");
?>"><?php
    echo esc_html($srow->notes);
?></textarea>
											</div>
								</div>	
                        </div>
                        <div class="card-footer">
							<button class="btn btn-flat btn-success" name="edit-file" type="submit"><?php
    echo esc_html__("Save", "ezy_sc-text");
?></button>
							<button type="reset" class="btn btn-flat btn-default"><?php
    echo esc_html__("Reset", "ezy_sc-text");
?></button>
				        </div>
                     </div>
				</form>
<?php
}
?>
				    <div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("File Whitelist", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
<table id="dt-basic2" class="table table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th><i class="fas fa-file-alt"></i> <?php
echo esc_html__("Path", "ezy_sc-text");
?></th>
											<th><i class="fas fa-clipboard"></i> <?php
echo esc_html__("Notes", "ezy_sc-text");
?></th>
											<th><i class="fas fa-cog"></i> <?php
echo esc_html__("Actions", "ezy_sc-text");
?></th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $wpdb->get_results("SELECT * FROM `$tablef`");
foreach ($query as $row) {
    echo '
										<tr>
						                    <td>' . esc_html($row->path) . '</td>
											<td>' . esc_html($row->notes) . '</td>
											<td>
                                            <a href="admin.php?page=ezy_sc-whitelist&edit-fid=' . esc_html($row->id) . '" class="btn btn-flat btn-warning"><i class="fas fa-edit"></i> ' . esc_html__("Edit", "ezy_sc-text") . '</a>
                                            <a href="admin.php?page=ezy_sc-whitelist&delete-fid=' . esc_html($row->id) . '" class="btn btn-flat btn-danger"><i class="fas fa-trash"></i> ' . esc_html__("Delete", "ezy_sc-text") . '</a>
											</td>
										</tr>
';
}
?>
									</tbody>
								</table>
                        </div>
                     </div>
                </div>

				<div class="col-md-3">
				     <div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Add File", "ezy_sc-text");
?></h3>
						</div>
				        <div class="card-body">
<form class="form-horizontal" action="" method="post">
                                <div class="form-group">
											<label class="control-label"><?php
echo esc_html__("File's Path", "ezy_sc-text");
?>: </label>
											<div class="col-sm-12">
												<input type="text" name="path" placeholder="folder/file.php" class="form-control" required>
											</div>
							    </div>
								<div class="form-group">
											<label class="control-label"><?php
echo esc_html__("Notes", "ezy_sc-text");
?>: </label>
											<div class="col-sm-12">
												<textarea rows="5" name="notes" class="form-control" placeholder="<?php
echo esc_html__("Additional (descriptive) information can be added here", "ezy_sc-text");
?>"></textarea>
											</div>
								</div>	
                        </div>
                        <div class="card-footer">
							<button class="btn btn-flat btn-primary btn-block" name="add-file" type="submit"><?php
echo esc_html__("Add", "ezy_sc-text");
?></button>
				        </div>
				     </div>
				</div>
</form>
                    
</div>

</div>