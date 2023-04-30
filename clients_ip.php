<span style="float:left;"><h4><a href="index.php?mode=clients&action=clientsip">Clients IP</a></h4></span>
<?php if ( in_array('clients_ip_add', $user_menu_permission)) {?>
  	<span style="float:right;"><h4 style="float:right; text-align:right;"><a href="index.php?mode=clients&action=clientsipadd">Add New</a></h4></span>
  <?php }?>
<?php 
$monthArray = array (1=>"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

$clientsArray = getRecordArray('clients', 'id', 'name');
?>

<div class="table-responsive">
<table class="table" width="100%">
<tbody>
<tr><td align="center">
<form class="navbar-form" action="index.php?mode=clients&action=clientsip&type=search" method="post" name="search">
  
   <?php //echo selectMenu1 ('clients', 'id', 'name', '', 'client_id', 'client_id', 'Clients', ' WHERE `extensions` > 0 AND `active` = \'Y\'', '', ' class="form-control" style="width:230px;"');?>&nbsp;
    <input class="form-control" name="client_name" id="client_name" size="30" type="text" value="" placeholder="Client Name">
    <select class="form-control" name="month" id="month" style="width:135px;">
        <option value="0">Month</option>
        <?php 
        foreach ($monthArray as $mkey=>$month) {
          echo '<option value="'.$mkey.'">'.$month.'</option>';
        }
        ?>
   </select>
   <select class="form-control" name="year" id="year" style="width:125px;">
        <option value="0">Year</option>
        <?php 
        foreach (range(2010, 2020) as $year) {
          echo '<option>'.$year.'</option>';
        }
        ?>
   </select>
   <input class="form-control" name="ip_address" id="ip_address" size="20" type="text" value="" placeholder="IP Address">
    <input class="form-control" name="sip_from" id="sip_from" size="7" maxlength="6" type="text" value="" placeholder="Sip No From">
    <input class="form-control" name="sip_to" id="sip_to" size="7" maxlength="6" type="text" value="" placeholder="Sip No To">
  
    <input name="btnSearch" value="Search" type="submit" class="btn btn-primary">
</form>
</td></tr>
</tbody></table>
</div>
<?php 
$url = 'index.php?mode=clients&action=clientsip';
$sqlSelect = 'SELECT *  FROM `client_ip` WHERE `id`> 0 ';
if(isset($_POST['btnSearch']) && $_POST['btnSearch'] == 'Search') 
{
	$url .= '&type=search';
	//print_r($_POST);
	
// 	if(isset($_POST['client_id']) && $_POST['client_id'] > 0)
// 		$sqlSelect .= ' AND `client_id` = \''.$_POST['client_id'].'\'';
	
	if(isset($_POST['client_name']) && $_POST['client_name'] !='')
		$sqlSelect .= ' AND `client_name` like \'%' . $_POST['client_name'] . '%\'';
	
	if(isset($_POST['ip_address']) && $_POST['ip_address'] != '')
		$sqlSelect .= ' AND `ip_address` = \'' . $_POST['ip_address'] . '\'';
		
	if(isset($_POST['month']) && $_POST['month'] > 0)
		$sqlSelect .= ' AND `month` = \''.$_POST['month'].'\'';
		
	if(isset($_POST['year']) && $_POST['year'] > 0)
		$sqlSelect .= ' AND `year` = \''.$_POST['year'].'\'';
	
	if((isset($_POST['sip_from']) && $_POST['sip_from'] != '') && (isset($_POST['sip_to']) && $_POST['sip_to'] != ''))
		$sqlSelect .= ' AND (\''.$_POST['sip_from'].'\' BETWEEN `sip_from` AND `sip_to`)';
	elseif(isset($_POST['sip_from']) && $_POST['sip_from'] != '')
		$sqlSelect .= ' AND `sip_from` = \''.$_POST['sip_from'].'\'';
	elseif(isset($_POST['sip_to']) && $_POST['sip_to'] != '')
		$sqlSelect .= ' AND `sip_to` = \''.$_POST['sip_to'].'\'';
	
	$sqlSelect .= ' ORDER BY `client_name` ASC';
	
	$_SESSION['search_client_ip'] = $sqlSelect;
	//echo $sqlSelect; //exit;
} elseif (isset($_GET['type']) && $_GET['type'] == 'search' && isset($_SESSION['search_client_ip']) && $_SESSION['search_client_ip'] != '') {
    $sqlSelect = $_SESSION['search_client_ip'];
    $url .= '&type=search';
} else {
    $sqlSelect .= ' ORDER BY `client_name` ASC';
    
    unset($_SESSION['search_client_ip']);
    $_SESSION['search_client_ip'] = $sqlSelect;
}
if($superAdmin)
	echo $sqlSelect;
// exit;
?>
<div class="table-responsive">
<table class="table table-bordered" width="100%">
	<thead>
		<tr class="info">
			<th colspan="8">
				<span style="float:left; width:50%;"><h4 style="float:left; width:70%;">Client IP</h4></span>
				<span style="float:right; width:30%; text-align:right;"><a href="index.php?mode=reports&action=export&opt=clientip">Export</a></span>
			</th>
		</tr>
		<tr class="info">
		  <th>Sl.</th>
		  <th>Client</th>
		  <th>Date</th>
		  <th>IP Address</th>
		  <th>Sip Number From</th>
		  <th>Sip Number To</th>
		  <th>Fixed</th>
		  <th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	//start paging
	$items_perpage  = 25;
	$page= $_GET['page'];
	$page = $page > 0 ? $page : 1;
	
	if($page > 1)
	  $offset = ($page - 1) * $items_perpage;
	else
	  $offset = 0;
	//echo $sqlSelect;exit;
	$querySelect = $mysqli->query($sqlSelect);
	//print_r(mysql_num_rows($querySelect));
	$total_records = $mysqli->numrow($querySelect);
	if( $total_records > 0) {
	$activeImage = '<img src="assets/images/active.png" border="0" title="Fixed" alt="Fixed-Yes">';
	    $sl = $items_perpage * ($page - 1) + 1 ; 
	    $sqlSelect1 = $sqlSelect . ' LIMIT '.$offset.', '.$items_perpage;
	    $querySelect1 = $mysqli->query($sqlSelect1, $link);
	    while($resultSelect = $querySelect1->fetch_assoc()) {
	?>
	        <tr <?php echo $sl % 2 == 0 ? 'class="info"' : '';?>>
	           <td width="4"><?php echo $sl++;?></td>
	           <td><?php echo $resultSelect['client_name'];//echo isset($clientsArray[$resultSelect['client_id']]) ? $clientsArray[$resultSelect['client_id']] : ($resultSelect['client_name'] ? $resultSelect['client_name'] : '');?>
	           </td>
	           <td><?php echo $monthArray[$resultSelect['month']];?> <?php echo $resultSelect['year'];?></td>
	           <td><?php echo $resultSelect['ip_address'];?></td>
	           <td><?php echo $resultSelect['sip_from'];?></td>
	           <td><?php echo $resultSelect['sip_to'];?></td>
	           <td><?php echo $resultSelect['fixed']==1 ? $activeImage : '';?></td>
	           <td>
	           <?php if ( in_array('clients_ip_edit', $user_menu_permission)) {?>
	           		<a href="index.php?mode=clients&action=clientsipedit&id=<?php echo $resultSelect['id'];?>" title="Edit"><img src="assets/images/pencil.png" alt="Edit"></a>
	           <?php } 
	           if ( in_array('clients_ip_delete', $user_menu_permission)) {?>
	           <a href="index.php?mode=clients&action=clientsipdelete&id=<?php echo $resultSelect['id'];?>" onclick="return confirm('Are you sure you want to Delete?')" title="Delete"><img src="assets/images/cross.png" alt="Delete"></a> </td>
	           <?php }?>
	          </tr>
	 
	<?php }
	} ?>
	</tbody>
	<tfoot>
      <tr><td colspan="8">
      <?php 
            //start paging
            // find out how many rows are in the table
            if($total_records > 0) {
              include('pagination.class.php');
              echo '<link href="assets/css/pagination.css" rel="stylesheet" type="text/css" />';
              $p = new pagination;
              $p->Items($total_records);
              $p->limit($items_perpage);
              $p->target($url);
              $p->currentPage($page);
              $p->adjacents(3);
              $p->changeClass("bluepaging");
              $p->parameterName('page');
              $p->show();
            }
          
            ?>
      </td></tr>
      </tfoot>
</table>
</div>