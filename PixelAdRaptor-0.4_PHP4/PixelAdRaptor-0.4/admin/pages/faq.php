<?php
/**
 *
 * Administration's faq section handler
 *
 * @date 2005-10-14
 * @file faq.php
 *
 * Copyright (C) 2005  Karolis Tamutis
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
 
$api['template']->set('page', 'faq.tpl');

if (!isset($_GET['act'])) {

    /**
     *
     * Parse addition form
     */
    if ($form->wasSubmitted('submit_q')) {
    
        $form->addRequired(array('question' => 'Question', 'answer' => 'Answer'));
     
        $form->performValidation();
        
        if ($form->isOk()) {
    
            if (!get_magic_quotes_gpc()) {
        
                $_POST = array_map('addslashes', $_POST);
        
            }
    
            $q = 'INSERT INTO faq (id, question, answer, weight) VALUES (null, "'.$_POST['question'].'", "'.$_POST['answer'].'", 0)';
            $api['database']->query($q);
        
            header('location: index.php?page=faq');
        
        } else {
    
            $api['template']->set('question', $_POST['question']);
            $api['template']->set('answer', $_POST['answer']);
    
            $api['template']->set('errors1', $form->getHtmlErrors());
            $api['template']->set('error_js1', $form->getJs());          
    
        }
    
    }
    
    /**
     *
     * Put questions
     */
    $q = 'SELECT * FROM faq ORDER BY weight DESC';
    $questions = $api['database']->getArray($api['database']->query($q));

    if (!empty($questions)) {
    
        if (!get_magic_quotes_gpc()) {
    
            foreach ($questions as $key => $value) {
        
                $questions[$key] = array_map('stripslashes', $value);
        
            }
    
        }
                
        $api['template']->set('subpage', 'faq_sort.tpl');
        $api['template']->set('faq', $questions);
        
    }
        
    /**
     *
     * Parse weight sorting form
     */
    if ($form->wasSubmitted('submit_sort')) {
         
        $form->performValidation();
        
        if ($form->isOk()) {
    
            $i = 0;
    
            foreach ($questions as $value) {
                
                $q = 'UPDATE faq SET weight = "'.$_POST['weight'][$i].'" WHERE id = "'.$value['id'].'"';
                $api['database']->query($q);
                $i++;
            }
            
            header('location: index.php?page=faq');
        
        } else {
    
            $api['template']->set('errors2', $form->getHtmlErrors());
            $api['template']->set('error_js2', $form->getJs());          
    
        }
    
    }
        
} elseif ($_GET['act'] == 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])) { 

    /**
     *
     * Set 
     */
    $q = 'DELETE FROM faq WHERE id = "'.$_GET['id'].'"';
    $api['database']->query($q);
    
    header('location: index.php?page=faq');
    
} elseif ($_GET['act'] == 'edit' && isset($_GET['id']) && is_numeric($_GET['id'])) {

    $api['template']->set('page', 'faq_edit.tpl');
    
    $q = 'SELECT question, answer FROM faq WHERE id = "'.$_GET['id'].'"';
    $question = $api['database']->getRow($api['database']->query($q));
    
    if (!get_magic_quotes_gpc()) {
    
        $question = array_map('stripslashes', $question);
    
    }
    
    $api['template']->set('question_e', $question['question']);
    $api['template']->set('answer_e', $question['answer']);
    
    /**
     *
     * Parse edit form
     */
    if ($form->wasSubmitted('submit_edit')) {
    
        $form->addRequired(array('question_e' => 'Question', 'answer_e' => 'Answer'));
     
        $form->performValidation();
        
        if ($form->isOk()) {
    
            if (!get_magic_quotes_gpc()) {
        
                $_POST = array_map('addslashes', $_POST);
        
            }
            
            $q = 'UPDATE faq SET question = "'.$_POST['question_e'].'", answer = "'.$_POST['answer_e'].'" WHERE id = "'.$_GET['id'].'"';
            $api['database']->query($q);
            
            header('location: index.php?page=faq');
             
       } else {
            
            $api['template']->set('question_e', $_POST['question_e']);
            $api['template']->set('answer_e', $_POST['answer_e']);
    
            $api['template']->set('errors2', $form->getHtmlErrors());
            $api['template']->set('error_js2', $form->getJs());           
          
       }

    }
    
}
?>