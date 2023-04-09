<?php
include('application_config_file.php');
if (defined("CRON_TYPE") && CRON_TYPE=='internal') {
    $cron_query=bx_db_query("SELECT *,UNIX_TIMESTAMP(cron_date) as lasttime FROM ".$bx_table_prefix."_cronjobs WHERE cron_date<=NOW() and ((cron_status!='running') or (cron_status='running' and NOW()>cron_start+600)) order by cron_priority ASC");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));   
    if (bx_db_num_rows($cron_query)>0) {
        $cron_jobs=array();
        $cron_last=array();
        define('INTERNAL_CRON','1');
        $er=mktime(23,55,0,date('m'),date('d'),date('Y'));
        $em=mktime(23,55,0,date('m'),date('d')+1,date('Y'));
        $admin_error=false;
        while ($cron_result=bx_db_fetch_array($cron_query)){
            bx_db_query("UPDATE ".$bx_table_prefix."_cronjobs set cron_status='running', cron_start=NOW() where cron_type = '".$cron_result['cron_type']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            $cron_jobs[]=$cron_result['cron_type'];
            $cron_last[]=$cron_result['lasttime'];
        }
        for ( $croni=0;$croni<sizeof($cron_jobs);$croni++) {
            if ($cron_jobs[$croni]=="jobmail") {
                $cron_status=false;
                @include(DIR_ADMIN."jobmail_cron.php");
                if (!$cron_status) {
                    $admin_error=true;
                    $admin_message.="Jobmail cron error: can't include file: ".DIR_ADMIN."jobmail_cron.php\n";
                }
                else {
                    if (($er-$cron_last[$croni])>4*3600) {
                        $new_cron_date = date('Y-m-d H:i:s', $er);
                    }
                    else {
                        $new_cron_date = date('Y-m-d H:i:s', $em);
                    }   
                    bx_db_query("UPDATE ".$bx_table_prefix."_cronjobs set cron_status='done', cron_date='".$new_cron_date."' where cron_type='".$cron_jobs[$croni]."'");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                }
            }
            elseif ($cron_jobs[$croni]=="resumemail") {
                $cron_status=false;
                @include(DIR_ADMIN."resumemail_cron.php");
                if (!$cron_status) {
                    $admin_error=true;
                    $admin_message.="Resumemail cron error: can't include file: ".DIR_ADMIN."resumemail_cron.php\n";
                }
                else {
                    if (($er-$cron_last[$croni])>4*3600) {
                        $new_cron_date = date('Y-m-d H:i:s', $er);
                    }
                    else {
                        $new_cron_date = date('Y-m-d H:i:s', $em);
                    }   
                    bx_db_query("UPDATE ".$bx_table_prefix."_cronjobs set cron_status='done', cron_date='".$new_cron_date."' where cron_type='".$cron_jobs[$croni]."'");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                }
            }
            elseif ($cron_jobs[$croni]=="expire") {
                $cron_status=false;
                @include(DIR_ADMIN."job_cron.php");
                if (!$cron_status) {
                    $admin_error=true;
                    $admin_message.="Expired job/plans cron error: can't include file: ".DIR_ADMIN."job_cron.php\n";
                }
                else {
                    if (($er-$cron_last[$croni])>4*3600) {
                        $new_cron_date = date('Y-m-d H:i:s', $er);
                    }
                    else {
                        $new_cron_date = date('Y-m-d H:i:s', $em);
                    }   
                    bx_db_query("UPDATE ".$bx_table_prefix."_cronjobs set cron_status='done', cron_date='".$new_cron_date."' where cron_type='".$cron_jobs[$croni]."'");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                }
            }
            else {}
        }
        if ($admin_error) {
            bx_mail(SITE_NAME,SITE_MAIL,SITE_MAIL,"Cron files error - ".date('l, d F Y'),$admin_message,"no"); 
        }    
    }
    header('Content-type: image/gif');
    echo fread(fopen(DIR_IMAGES.$language."/pix-t.gif","r"),filesize(DIR_IMAGES.$language."/login.gif")); 
}
else {
    header('Content-type: image/gif');
    echo fread(fopen(DIR_IMAGES.$language."/pix-t.gif","r"),filesize(DIR_IMAGES.$language."/pix-t.gif")); 
}
bx_exit();
?>