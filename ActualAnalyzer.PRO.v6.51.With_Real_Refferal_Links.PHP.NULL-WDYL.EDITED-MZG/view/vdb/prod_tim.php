<?php

  $maxlen=105;
  $dy=getdate($conf->dtime-40000);
  $ydtime=mktime(0,0,0,$dy['mon'],$dy['mday'],$dy['year'],0);
  $lyear=(int)(date('y',$conf->ctime))-(int)(date('y',$conf->btime))+1;
  $values='IF(modify>='.$conf->dtime.',vt,0) AS vt,IF(modify>='.$conf->dtime.',hst,0) AS hst,IF(modify>='.$conf->dtime.',htt,0) AS htt';
  $values.=',IF(modify>='.$conf->dtime.',vy,vt) AS vy,IF(modify>='.$conf->dtime.',hsy,hst) AS hsy,IF(modify>='.$conf->dtime.',hty,htt) AS hty';
  $values.=',IF(modify>='.$conf->wtime.',vw,0) AS vw,IF(modify>='.$conf->wtime.',hsw,0) AS hsw,IF(modify>='.$conf->wtime.',htw,0) AS htw';
  $values.=',IF(modify>='.$conf->wtime.',vlw,vw) AS vlw,IF(modify>='.$conf->wtime.',hslw,hsw) AS hslw,IF(modify>='.$conf->wtime.',htlw,htw) AS htlw';
  $values.=',IF(modify>='.$conf->mtime.',vm,0) AS vm,IF(modify>='.$conf->mtime.',hsm,0) AS hsm,IF(modify>='.$conf->mtime.',htm,0) AS htm';
  $values.=',IF(modify>='.$conf->mtime.',vlm,vm) AS vlm,IF(modify>='.$conf->mtime.',hslm,hsm) AS hslm,IF(modify>='.$conf->mtime.',htlm,htm) AS htlm';
  $vvalues='v1'; $hsvalues='hs1'; $htvalues='ht1';
  for($i=2;$i<=$lyear;$i++) { $vvalues.='+v'.$i; $hsvalues.='+hs'.$i; $htvalues.='+ht'.$i; }
  $values.=',('.$vvalues.') AS v,('.$hsvalues.') AS hs,('.$htvalues.') AS ht';

  if($page_id>200) $request='LOCK TABLES aa_vectors READ,aa_points READ,aa_groups READ';
  else $request='LOCK TABLES aa_vectors READ,aa_points READ,aa_pages READ';
  $result=mysql_query($request,$conf->link);
  if(!$result) {$err->reason('vdb.php|prod_tim|blocking of tables has failed -- '.mysql_error());return;}

  //ENTRY aa_vectors
  $request='SELECT '.$values.' FROM aa_vectors WHERE destid='.$page_id;
  $resultenv=mysql_query($request,$conf->link);
  if(!$resultenv) {$err->reason('vdb.php|prod_tim|the request \''.$request.'\' has failed -- '.mysql_error());return;}
  //EXIT aa_vectors
  $request='SELECT '.$values.' FROM aa_vectors WHERE sourid='.$page_id;
  $resultexv=mysql_query($request,$conf->link);
  if(!$resultexv) {$err->reason('vdb.php|prod_tim|the request \''.$request.'\' has failed -- '.mysql_error());return;}
  //ENTRY/EXIT aa_points
  $request='SELECT flag,'.$values.' FROM aa_points WHERE id='.$page_id.' AND flag!=3';
  $resultp=mysql_query($request,$conf->link);
  if(!$resultp) {$err->reason('vdb.php|prod_tim|the request \''.$request.'\' has failed -- '.mysql_error());return;}

  $request='UNLOCK TABLES';
  $resultu=mysql_query($request,$conf->link);
  if(!$resultu) {$err->reason('vdb.php|prod_tim|the request \''.$request.'\' has failed -- '.mysql_error());return;}

  $enval=array();
  $exval=array();
  $percent=array();
  $enval['vt']=0;  $enval['hst']=0;  $enval['htt']=0;
  $enval['vy']=0;  $enval['hsy']=0;  $enval['hty']=0;
  $enval['vw']=0;  $enval['hsw']=0;  $enval['htw']=0;
  $enval['vlw']=0; $enval['hslw']=0; $enval['htlw']=0;
  $enval['vm']=0;  $enval['hsm']=0;  $enval['htm']=0;
  $enval['vlm']=0; $enval['hslm']=0; $enval['htlm']=0;
  $enval['v']=0;   $enval['hs']=0;   $enval['ht']=0;
  $exval['vt']=0;  $exval['hst']=0;  $exval['htt']=0;
  $exval['vy']=0;  $exval['hsy']=0;  $exval['hty']=0;
  $exval['vw']=0;  $exval['hsw']=0;  $exval['htw']=0;
  $exval['vlw']=0; $exval['hslw']=0; $exval['htlw']=0;
  $exval['vm']=0;  $exval['hsm']=0;  $exval['htm']=0;
  $exval['vlm']=0; $exval['hslm']=0; $exval['htlm']=0;
  $exval['v']=0;   $exval['hs']=0;   $exval['ht']=0;
  while($row=mysql_fetch_object($resultenv)) {
      $enval['vt']+=$row->vt;   $enval['hst']+=$row->hst;   $enval['htt']+=$row->htt;
      $enval['vy']+=$row->vy;   $enval['hsy']+=$row->hsy;   $enval['hty']+=$row->hty;
      $enval['vw']+=$row->vw;   $enval['hsw']+=$row->hsw;   $enval['htw']+=$row->htw;
      $enval['vlw']+=$row->vlw; $enval['hslw']+=$row->hslw; $enval['htlw']+=$row->htlw;
      $enval['vm']+=$row->vm;   $enval['hsm']+=$row->hsm;   $enval['htm']+=$row->htm;
      $enval['vlm']+=$row->vlm; $enval['hslm']+=$row->hslm; $enval['htlm']+=$row->htlm;
      $enval['v']+=$row->v;     $enval['hs']+=$row->hs;     $enval['ht']+=$row->ht;
  }
  mysql_free_result($resultenv);
  while($row=mysql_fetch_object($resultexv)) {
      $exval['vt']+=$row->vt;   $exval['hst']+=$row->hst;   $exval['htt']+=$row->htt;
      $exval['vy']+=$row->vy;   $exval['hsy']+=$row->hsy;   $exval['hty']+=$row->hty;
      $exval['vw']+=$row->vw;   $exval['hsw']+=$row->hsw;   $exval['htw']+=$row->htw;
      $exval['vlw']+=$row->vlw; $exval['hslw']+=$row->hslw; $exval['htlw']+=$row->htlw;
      $exval['vm']+=$row->vm;   $exval['hsm']+=$row->hsm;   $exval['htm']+=$row->htm;
      $exval['vlm']+=$row->vlm; $exval['hslm']+=$row->hslm; $exval['htlm']+=$row->htlm;
      $exval['v']+=$row->v;     $exval['hs']+=$row->hs;     $exval['ht']+=$row->ht;
  }
  mysql_free_result($resultexv);
  while($row=mysql_fetch_object($resultp)) {
      if($row->flag==1) {
          $enval['vt']+=$row->vt;   $enval['hst']+=$row->hst;   $enval['htt']+=$row->htt;
          $enval['vy']+=$row->vy;   $enval['hsy']+=$row->hsy;   $enval['hty']+=$row->hty;
          $enval['vw']+=$row->vw;   $enval['hsw']+=$row->hsw;   $enval['htw']+=$row->htw;
          $enval['vlw']+=$row->vlw; $enval['hslw']+=$row->hslw; $enval['htlw']+=$row->htlw;
          $enval['vm']+=$row->vm;   $enval['hsm']+=$row->hsm;   $enval['htm']+=$row->htm;
          $enval['vlm']+=$row->vlm; $enval['hslm']+=$row->hslm; $enval['htlm']+=$row->htlm;
          $enval['v']+=$row->v;     $enval['hs']+=$row->hs;     $enval['ht']+=$row->ht;
      }
//      else {
//          $exval['vt']+=$row->vt;   $exval['hst']+=$row->hst;   $exval['htt']+=$row->htt;
//          $exval['vy']+=$row->vy;   $exval['hsy']+=$row->hsy;   $exval['hty']+=$row->hty;
//          $exval['vw']+=$row->vw;   $exval['hsw']+=$row->hsw;   $exval['htw']+=$row->htw;
//          $exval['vlw']+=$row->vlw; $exval['hslw']+=$row->hslw; $exval['htlw']+=$row->htlw;
//          $exval['vm']+=$row->vm;   $exval['hsm']+=$row->hsm;   $exval['htm']+=$row->htm;
//          $exval['vlm']+=$row->vlm; $exval['hslm']+=$row->hslm; $exval['htlm']+=$row->htlm;
//          $exval['v']+=$row->v;     $exval['hs']+=$row->hs;     $exval['ht']+=$row->ht;
//      }
  }
  mysql_free_result($resultp);
  $percent['vt']=$enval['vt']?sprintf('%.2f',$exval['vt']/$enval['vt']*100):sprintf('%.2f',$exval['vt']*100);
  $percent['vy']=$enval['vy']?sprintf('%.2f',$exval['vy']/$enval['vy']*100):sprintf('%.2f',$exval['vy']*100);
  $percent['vw']=$enval['vw']?sprintf('%.2f',$exval['vw']/$enval['vw']*100):sprintf('%.2f',$exval['vw']*100);
  $percent['vlw']=$enval['vlw']?sprintf('%.2f',$exval['vlw']/$enval['vlw']*100):sprintf('%.2f',$exval['vlw']*100);
  $percent['vm']=$enval['vm']?sprintf('%.2f',$exval['vm']/$enval['vm']*100):sprintf('%.2f',$exval['vm']*100);
  $percent['vlm']=$enval['vlm']?sprintf('%.2f',$exval['vlm']/$enval['vlm']*100):sprintf('%.2f',$exval['vlm']*100);
  $percent['v']=$enval['v']?sprintf('%.2f',$exval['v']/$enval['v']*100):sprintf('%.2f',$exval['v']*100);
  $percent['hst']=$enval['hst']?sprintf('%.2f',$exval['hst']/$enval['hst']*100):sprintf('%.2f',$exval['hst']*100);
  $percent['hsy']=$enval['hsy']?sprintf('%.2f',$exval['hsy']/$enval['hsy']*100):sprintf('%.2f',$exval['hsy']*100);
  $percent['hsw']=$enval['hsw']?sprintf('%.2f',$exval['hsw']/$enval['hsw']*100):sprintf('%.2f',$exval['hsw']*100);
  $percent['hslw']=$enval['hslw']?sprintf('%.2f',$exval['hslw']/$enval['hslw']*100):sprintf('%.2f',$exval['hslw']*100);
  $percent['hsm']=$enval['hsm']?sprintf('%.2f',$exval['hsm']/$enval['hsm']*100):sprintf('%.2f',$exval['hsm']*100);
  $percent['hslm']=$enval['hslm']?sprintf('%.2f',$exval['hslm']/$enval['hslm']*100):sprintf('%.2f',$exval['hslm']*100);
  $percent['hs']=$enval['hs']?sprintf('%.2f',$exval['hs']/$enval['hs']*100):sprintf('%.2f',$exval['hs']*100);
  $percent['htt']=$enval['htt']?sprintf('%.2f',$exval['htt']/$enval['htt']*100):sprintf('%.2f',$exval['htt']*100);
  $percent['hty']=$enval['hty']?sprintf('%.2f',$exval['hty']/$enval['hty']*100):sprintf('%.2f',$exval['hty']*100);
  $percent['htw']=$enval['htw']?sprintf('%.2f',$exval['htw']/$enval['htw']*100):sprintf('%.2f',$exval['htw']*100);
  $percent['htlw']=$enval['htlw']?sprintf('%.2f',$exval['htlw']/$enval['htlw']*100):sprintf('%.2f',$exval['htlw']*100);
  $percent['htm']=$enval['htm']?sprintf('%.2f',$exval['htm']/$enval['htm']*100):sprintf('%.2f',$exval['htm']*100);
  $percent['htlm']=$enval['htlm']?sprintf('%.2f',$exval['htlm']/$enval['htlm']*100):sprintf('%.2f',$exval['htlm']*100);
  $percent['ht']=$enval['ht']?sprintf('%.2f',$exval['ht']/$enval['ht']*100):sprintf('%.2f',$exval['ht']*100);

  require './style/'.$conf->style.'/template/vti_pr_a.php';
  $vars['HEADER']=_SUMMARY.' / ';
  $vars['RHEADER']=_PRODOFGRPG;
  $vars['THEADER']=_ALLTIME.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['SHOWING']=_SHOWING.' 7 '._INTERVAL_S;
  $fname=$name;
  if(strlen($fname)>_VS_PGSTITLITEM) $sname=substr($fname,0,_VS_PGSTITLITEM-3).'...';
  else $sname=$fname;
  if($page_id>200) $vars['FPG']=_FORGR." '<b><i>".$name."</i></b>'";
  else $vars['FPG']=_FORPG.' \'<b><i><a href="'.$url.'" title="'.$fname.'" target=_blank><code>'.$sname."</code></a></i></b>'";
  $vars['BACKTT']=_BACKTOTOP;
  $vars['PERIOD']=_TIMEINT;
  $vars['VISITORS']=_VISITORS;
  $vars['HOSTS']=_HOSTS;
  $vars['HITS']=_HITS;
  $vars['REF']='summary';
  $vars['DETAIL']=_DETAILED;
  tparse($top,$vars);
  $maxv=0;
  $maxhs=0;
  $maxr=0;
  $maxht=0;
  $vars['INTERVAL']='total';
  $vars['PERIOD']=_TOTAL.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['VISITORS']=$percent['v'];
  $vars['HOSTS']=$percent['hs'];
  $vars['HITS']=$percent['ht'];
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='lastmonth';
  if($conf->btime>=$conf->lmtime&&$conf->btime<$conf->mtime) $vars['PERIOD']=_LASTMONTH.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->mtime-7200).')';
  else $vars['PERIOD']=_LASTMONTH.' ('.date($conf->dmas[$conf->dformat],$conf->lmtime).' - '.date($conf->dmas[$conf->dformat],$conf->mtime-7200).')';
  $vars['VISITORS']=$percent['vlm'];
  $vars['HOSTS']=$percent['hslm'];
  $vars['HITS']=$percent['htlm'];
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='month';
  if($conf->btime>$conf->mtime) $vars['PERIOD']=_MONTH.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  else $vars['PERIOD']=_MONTH.' ('.date($conf->dmas[$conf->dformat],$conf->mtime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['VISITORS']=$percent['vm'];
  $vars['HOSTS']=$percent['hsm'];
  $vars['HITS']=$percent['htm'];
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='lastweek';
  if($conf->btime>=$conf->lwtime&&$conf->btime<$conf->wtime) $vars['PERIOD']=_LASTWEEK.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->wtime-7200).')';
  else $vars['PERIOD']=_LASTWEEK.' ('.date($conf->dmas[$conf->dformat],$conf->lwtime).' - '.date($conf->dmas[$conf->dformat],$conf->wtime-7200).')';
  $vars['VISITORS']=$percent['vlw'];
  $vars['HOSTS']=$percent['hslw'];
  $vars['HITS']=$percent['htlw'];
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='week';
  if($conf->btime>$conf->wtime) $vars['PERIOD']=_WEEK.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  else $vars['PERIOD']=_WEEK.' ('.date($conf->dmas[$conf->dformat],$conf->wtime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['VISITORS']=$percent['vw'];
  $vars['HOSTS']=$percent['hsw'];
  $vars['HITS']=$percent['htw'];
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='yesterday';
  $vars['PERIOD']=_YESTERDAY.' ('.date($conf->dmas[$conf->dformat],$ydtime).')';
  $vars['VISITORS']=$percent['vy'];
  $vars['HOSTS']=$percent['hsy'];
  $vars['HITS']=$percent['hty'];
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='today';
  $vars['PERIOD']=_TODAY.' ('.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['VISITORS']=$percent['vt'];
  $vars['HOSTS']=$percent['hst'];
  $vars['HITS']=$percent['htt'];
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $maxv=max($maxv,$percent['v'],$percent['vlm'],$percent['vm'],$percent['vlw'],$percent['vw'],$percent['vy'],$percent['vt']);
  $maxhs=max($maxhs,$percent['hs'],$percent['hslm'],$percent['hsm'],$percent['hslw'],$percent['hsw'],$percent['hsy'],$percent['hst']);
  $maxht=max($maxht,$percent['ht'],$percent['htlm'],$percent['htm'],$percent['htlw'],$percent['htw'],$percent['hty'],$percent['htt']);
  tparse($bottom,$vars);

  require './style/'.$conf->style.'/template/vti_pr_d.php';
  // VISITORS
  $vars['PERIOD']=_TIMEINT;
  $vars['IN']=_IN;
  $vars['OUT']=_OUT;
  $vars['PER']='%';
  $vars['GRAPHIC']=_GRAPHIC;
  $vars['HEADER']=_VISITORS.' / ';
  $vars['REF']='visitors';
  tparse($top,$vars);
  $vars['INTERVAL']='total';
  $vars['PERIOD']=_TOTAL.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['v'];
  $vars['OUT']=$exval['v'];
  $vars['PER']=$percent['v'];
  $vars['GRAPHIC']=$maxv?$maxlen*$percent['v']/$maxv:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='lastmonth';
  if($conf->btime>=$conf->lmtime&&$conf->btime<$conf->mtime) $vars['PERIOD']=_LASTMONTH.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->mtime-7200).')';
  else $vars['PERIOD']=_LASTMONTH.' ('.date($conf->dmas[$conf->dformat],$conf->lmtime).' - '.date($conf->dmas[$conf->dformat],$conf->mtime-7200).')';
  $vars['IN']=$enval['vlm'];
  $vars['OUT']=$exval['vlm'];
  $vars['PER']=$percent['vlm'];
  $vars['GRAPHIC']=$maxv?$maxlen*$percent['vlm']/$maxv:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='month';
  if($conf->btime>$conf->mtime) $vars['PERIOD']=_MONTH.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  else $vars['PERIOD']=_MONTH.' ('.date($conf->dmas[$conf->dformat],$conf->mtime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['vm'];
  $vars['OUT']=$exval['vm'];
  $vars['PER']=$percent['vm'];
  $vars['GRAPHIC']=$maxv?$maxlen*$percent['vm']/$maxv:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='lastweek';
  if($conf->btime>=$conf->lwtime&&$conf->btime<$conf->wtime) $vars['PERIOD']=_LASTWEEK.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->wtime-7200).')';
  else $vars['PERIOD']=_LASTWEEK.' ('.date($conf->dmas[$conf->dformat],$conf->lwtime).' - '.date($conf->dmas[$conf->dformat],$conf->wtime-7200).')';
  $vars['IN']=$enval['vlw'];
  $vars['OUT']=$exval['vlw'];
  $vars['PER']=$percent['vlw'];
  $vars['GRAPHIC']=$maxv?$maxlen*$percent['vlw']/$maxv:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='week';
  if($conf->btime>$conf->wtime) $vars['PERIOD']=_WEEK.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  else $vars['PERIOD']=_WEEK.' ('.date($conf->dmas[$conf->dformat],$conf->wtime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['vw'];
  $vars['OUT']=$exval['vw'];
  $vars['PER']=$percent['vw'];
  $vars['GRAPHIC']=$maxv?$maxlen*$percent['vw']/$maxv:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='yesterday';
  $vars['PERIOD']=_YESTERDAY.' ('.date($conf->dmas[$conf->dformat],$ydtime).')';
  $vars['IN']=$enval['vy'];
  $vars['OUT']=$exval['vy'];
  $vars['PER']=$percent['vy'];
  $vars['GRAPHIC']=$maxv?$maxlen*$percent['vy']/$maxv:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='today';
  $vars['PERIOD']=_TODAY.' ('.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['vt'];
  $vars['OUT']=$exval['vt'];
  $vars['PER']=$percent['vt'];
  $vars['GRAPHIC']=$maxv?$maxlen*$percent['vt']/$maxv:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  tparse($bottom,$vars);
  // HOSTS
  $vars['PERIOD']=_TIMEINT;
  $vars['IN']=_IN;
  $vars['OUT']=_OUT;
  $vars['PER']='%';
  $vars['GRAPHIC']=_GRAPHIC;
  $vars['HEADER']=_HOSTS.' / ';
  $vars['REF']='hosts';
  tparse($top,$vars);
  $vars['INTERVAL']='total';
  $vars['PERIOD']=_TOTAL.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['hs'];
  $vars['OUT']=$exval['hs'];
  $vars['PER']=$percent['hs'];
  $vars['GRAPHIC']=$maxhs?$maxlen*$percent['hs']/$maxhs:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='lastmonth';
  if($conf->btime>=$conf->lmtime&&$conf->btime<$conf->mtime) $vars['PERIOD']=_LASTMONTH.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->mtime-7200).')';
  else $vars['PERIOD']=_LASTMONTH.' ('.date($conf->dmas[$conf->dformat],$conf->lmtime).' - '.date($conf->dmas[$conf->dformat],$conf->mtime-7200).')';
  $vars['IN']=$enval['hslm'];
  $vars['OUT']=$exval['hslm'];
  $vars['PER']=$percent['hslm'];
  $vars['GRAPHIC']=$maxhs?$maxlen*$percent['hslm']/$maxhs:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='month';
  if($conf->btime>$conf->mtime) $vars['PERIOD']=_MONTH.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  else $vars['PERIOD']=_MONTH.' ('.date($conf->dmas[$conf->dformat],$conf->mtime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['hsm'];
  $vars['OUT']=$exval['hsm'];
  $vars['PER']=$percent['hsm'];
  $vars['GRAPHIC']=$maxhs?$maxlen*$percent['hsm']/$maxhs:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='lastweek';
  if($conf->btime>=$conf->lwtime&&$conf->btime<$conf->wtime) $vars['PERIOD']=_LASTWEEK.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->wtime-7200).')';
  else $vars['PERIOD']=_LASTWEEK.' ('.date($conf->dmas[$conf->dformat],$conf->lwtime).' - '.date($conf->dmas[$conf->dformat],$conf->wtime-7200).')';
  $vars['IN']=$enval['hslw'];
  $vars['OUT']=$exval['hslw'];
  $vars['PER']=$percent['hslw'];
  $vars['GRAPHIC']=$maxhs?$maxlen*$percent['hslw']/$maxhs:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='week';
  if($conf->btime>$conf->wtime) $vars['PERIOD']=_WEEK.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  else $vars['PERIOD']=_WEEK.' ('.date($conf->dmas[$conf->dformat],$conf->wtime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['hsw'];
  $vars['OUT']=$exval['hsw'];
  $vars['PER']=$percent['hsw'];
  $vars['GRAPHIC']=$maxhs?$maxlen*$percent['hsw']/$maxhs:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='yesterday';
  $vars['PERIOD']=_YESTERDAY.' ('.date($conf->dmas[$conf->dformat],$ydtime).')';
  $vars['IN']=$enval['hsy'];
  $vars['OUT']=$exval['hsy'];
  $vars['PER']=$percent['hsy'];
  $vars['GRAPHIC']=$maxhs?$maxlen*$percent['hsy']/$maxhs:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='today';
  $vars['PERIOD']=_TODAY.' ('.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['hst'];
  $vars['OUT']=$exval['hst'];
  $vars['PER']=$percent['hst'];
  $vars['GRAPHIC']=$maxhs?$maxlen*$percent['hst']/$maxhs:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  tparse($bottom,$vars);
  // HITS
  $vars['PERIOD']=_TIMEINT;
  $vars['IN']=_IN;
  $vars['OUT']=_OUT;
  $vars['PER']='%';
  $vars['GRAPHIC']=_GRAPHIC;
  $vars['HEADER']=_HITS.' / ';
  $vars['REF']='hits';
  tparse($top,$vars);
  $vars['INTERVAL']='total';
  $vars['PERIOD']=_TOTAL.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['ht'];
  $vars['OUT']=$exval['ht'];
  $vars['PER']=$percent['ht'];
  $vars['GRAPHIC']=$maxht?$maxlen*$percent['ht']/$maxht:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='lastmonth';
  if($conf->btime>=$conf->lmtime&&$conf->btime<$conf->mtime) $vars['PERIOD']=_LASTMONTH.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->mtime-7200).')';
  else $vars['PERIOD']=_LASTMONTH.' ('.date($conf->dmas[$conf->dformat],$conf->lmtime).' - '.date($conf->dmas[$conf->dformat],$conf->mtime-7200).')';
  $vars['IN']=$enval['htlm'];
  $vars['OUT']=$exval['htlm'];
  $vars['PER']=$percent['htlm'];
  $vars['GRAPHIC']=$maxht?$maxlen*$percent['htlm']/$maxht:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='month';
  if($conf->btime>$conf->mtime) $vars['PERIOD']=_MONTH.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  else $vars['PERIOD']=_MONTH.' ('.date($conf->dmas[$conf->dformat],$conf->mtime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['htm'];
  $vars['OUT']=$exval['htm'];
  $vars['PER']=$percent['htm'];
  $vars['GRAPHIC']=$maxht?$maxlen*$percent['htm']/$maxht:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='lastweek';
  if($conf->btime>=$conf->lwtime&&$conf->btime<$conf->wtime) $vars['PERIOD']=_LASTWEEK.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->wtime-7200).')';
  else $vars['PERIOD']=_LASTWEEK.' ('.date($conf->dmas[$conf->dformat],$conf->lwtime).' - '.date($conf->dmas[$conf->dformat],$conf->wtime-7200).')';
  $vars['IN']=$enval['htlw'];
  $vars['OUT']=$exval['htlw'];
  $vars['PER']=$percent['htlw'];
  $vars['GRAPHIC']=$maxht?$maxlen*$percent['htlw']/$maxht:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='week';
  if($conf->btime>$conf->wtime) $vars['PERIOD']=_WEEK.' ('.date($conf->dmas[$conf->dformat],$conf->btime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  else $vars['PERIOD']=_WEEK.' ('.date($conf->dmas[$conf->dformat],$conf->wtime).' - '.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['htw'];
  $vars['OUT']=$exval['htw'];
  $vars['PER']=$percent['htw'];
  $vars['GRAPHIC']=$maxht?$maxlen*$percent['htw']/$maxht:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='yesterday';
  $vars['PERIOD']=_YESTERDAY.' ('.date($conf->dmas[$conf->dformat],$ydtime).')';
  $vars['IN']=$enval['hty'];
  $vars['OUT']=$exval['hty'];
  $vars['PER']=$percent['hty'];
  $vars['GRAPHIC']=$maxht?$maxlen*$percent['hty']/$maxht:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  $vars['INTERVAL']='today';
  $vars['PERIOD']=_TODAY.' ('.date($conf->dmas[$conf->dformat],$conf->ctime).')';
  $vars['IN']=$enval['htt'];
  $vars['OUT']=$exval['htt'];
  $vars['PER']=$percent['htt'];
  $vars['GRAPHIC']=$maxht?$maxlen*$percent['htt']/$maxht:0;
  if($page_id<201) tparse($centerp,$vars);
  else tparse($centerg,$vars);
  tparse($bottom,$vars);

?>
