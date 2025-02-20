<?php

class role
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM roles";
        return $this->db->selectAll($sql);
    }

    public function selectAllWithOutCustomer()
    {
        $sql = "SELECT * FROM roles WHERE idRole != 1";
        return $this->db->selectAll($sql);
    }

    public function selectAllTask()
    {
        $sql = "SELECT * FROM tasks";
        return $this->db->selectAll($sql);
    }

    public function selectAllPermission()
    {
        $sql = "SELECT * FROM permissiongroups";
        return $this->db->selectAll($sql);
    }

    public function selectRole($id)
    {
        $sql = "SELECT * FROM roles WHERE idRole = $id";
        return $this->db->selectAll($sql)->fetch_assoc();
    }

    public function selectRoleById($id)
    {
        $sql = "SELECT *
            FROM roles JOIN roledetail ON roles.idRole = roledetail.idRole
            WHERE roles.idRole = $id
            GROUP BY idPermission";
        return $this->db->selectAll($sql);
    }

    public function selectTaskById($idRole, $idPermission)
    {
        $sql = "SELECT *
            FROM roles JOIN roledetail ON roles.idRole = roledetail.idRole
            WHERE roles.idRole = $idRole
            and roledetail.idPermission = $idPermission
            GROUP BY idTask";
        return $this->db->selectAll($sql);
    }
    public function checkPermissionLook($idRole, $idPermission)
    {
        $sql = "SELECT *
            FROM roles JOIN roledetail ON roles.idRole = roledetail.idRole
            WHERE roles.idRole = $idRole
            and roledetail.idPermission = $idPermission and roles.idRole !=1 
            GROUP BY idTask";
        return $this->db->selectAll($sql);
    }

    public function selectRoleDetailByIdPermission($idRole, $idPermission)
    {
        $sql = "SELECT roledetail.idRole, roledetail.idPermission, roledetail.idTask, permissiongroups.permissionName
            FROM roledetail JOIN permissiongroups ON roledetail.idPermission = permissiongroups.idPermission
            JOIN tasks ON roledetail.idTask = tasks.idTask
            WHERE roledetail.idRole = $idRole AND roledetail.idPermission = $idPermission
            ORDER BY roledetail.idTask ASC";
        $result = $this->db->selectAll($sql);
        $arr = array();
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function insertRole($name)
    {
        $sql = "INSERT INTO roles (roleName) VALUES ('$name')";
        return $this->db->insert($sql);
    }

    public function insertRoleDetail($idRole, $idTask, $idPermission)
    {
        $sql = "UPDATE ROLES SET UPDATEAT = NOW() WHERE idRole = $idRole";
        $this->db->update($sql);
        $sql = "INSERT INTO roledetail (idRole, idPermission, idTask) VALUES ($idRole, $idPermission, $idTask)";
        return $this->db->insert($sql);
    }

    public function deleteRole($id)
    {
        $sql = "DELETE FROM ROLEDETAIL WHERE idRole = $id";
        $this->db->delete($sql);
        $sql = "DELETE FROM roles WHERE idRole = $id";
        return $this->db->delete($sql);
    }

    public function deleteAllRoleDetail($idRole)
    {
        $sql = "DELETE FROM roledetail WHERE idRole = $idRole";
        return $this->db->delete($sql);
    }
}

?>