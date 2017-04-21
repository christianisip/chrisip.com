
<?php
define ("BR","<br>\n");
echo "dn,SamAccountName,userPrincipalName,objectClass".BR;
for($i= 1 ; $i<=100; $i++)
{
  echo "\"cn=CSV AdminPool$i,ou=AdministrationPool,dc=IsipProject, dc=local\",CSVAdminPool$i,CSVAdminPool$i@IsipProject.local,user".BR;
}

?>
