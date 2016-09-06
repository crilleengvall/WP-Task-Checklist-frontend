<?php
 /*
 Task checklist - frontend is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 Task checklist - frontend is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Task checklist - frontend.  If not, see <https://www.gnu.org/licenses/gpl-3.0.html>.
 */

 class TCFPrintMarkup {
   function create_tasklist_markup($posts) {
     $html = '<div class="tcf-wrap">';
     foreach ($posts as $key => $post) {
       $html .= '<div class="tcf-task">';
       $html .= '<div class="tcf-btn" id="task-' . $post->ID . '"><i class="fa fa-check" aria-hidden="true"></i>';
       $html .= '</div>';
       $html .= '<h2>' . $post->post_title . '</h2>';
       $html .= '<p>' . $post->post_content . '</p>';
       $html .= '</div>';
     }
     $html .= '</div>';
     return $html;
   }
 }
