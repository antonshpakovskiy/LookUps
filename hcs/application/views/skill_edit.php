<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Add a Skill</title>
    <link href="<?php echo base_url(); ?>style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="content">
        <h1><?php echo $title; ?></h1>
        <?php echo $message; ?>
        <form method="post" action="<?php echo $action; ?>">
        <div class="data">
            <table>
                <tr>
                    <td width="30%">ID</td>
                    <td><input type="text" name="skill_id" disabled="disable" 
                               class="text" size="11"
                               value="<?php echo set_value('skill_id',$skill_id); ?>"/></td>
                </tr>
                <tr>
                    <td valign="top">Skill<span style="color:red;">*</span></td>
                    <td><input type="text" name="skill_txt"
                                class="text" size="30" 
                                value="<?php echo set_value('skill_txt',$skill_txt); ?>"/>
                </tr>
                <tr>
                    <td valign="top">Time stamp</td>
                    <td><input type="text" name="update_dt_tm" disabled="disable" 
                                class="text" size="30"
                                value="<?php echo set_value('update_dt_tm',$update_dt_tm); ?>" />
                </tr>
                <tr>
                    <td valign="top">Updated by</td>
                    <td><input type="text" name="update_user_id" disabled="disable" 
                                class="text" size="30"
                                value="<?php echo set_value('update_user_id',$update_user_id) ?>" />
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" value="Save"/></td>
                </tr>
            </table>
        </div>
        </form>
        <br />
        <?php echo $link_back; ?>
    </div>
</body>
</html>