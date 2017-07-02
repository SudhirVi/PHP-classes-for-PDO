# PHP classes for PDO
<h2>How to use.</h2>

<h4>Include Files</h4>
<pre>include_once "singleton.php";
include_once "db.php";</pre>

<h4>Create Singleton Object</h4>
<pre>$db = DB::getInstance();</pre>

<h4>Fetching</h4>
<pre>
$result = $db->select("SELECT * FROM `product` WHERE name = :name ",['name'=>'test']);
print_r($result);
</pre>

<h4>Updating</h4>
<pre>
$affected = $db->update("UPDATE `product` SET `name` = :name, updated_at =:updated_at WHERE `id` = :id",['name'=>'test200','id'=>2,'updated_at'=>date('Y-m-d H:i:s')]);
echo "Updated Rows: ".($affected);
</pre>

<h4>Inserting</h4>
<pre>
$insert = $db->insert("INSERT INTO `product`(`name`, `status`, `created_at`) VALUES (:name,:status,:created_at)",['name'=>'test','status'=>1,'created_at'=>date('Y-m-d H:i:s')]);
echo "Insert ID: ".($insert);
</pre>

<h4>Deleting</h4>
<pre>
$affected = $db->update("DELETE FROM `product` WHERE `id` = :id",['id'=>2]);
echo "Deleted Rows: ".($affected);
</pre>
