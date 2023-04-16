<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cron_job_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();    

        $this->load->helper('url');   

    }

    /**
     * Get lead
     * @param  string $id Optional - leadid
     * @return mixed
     */
    public function birthday()
    {
        $this->load->config('email');
        $this->load->library('email');
                        
        $htmlContent = '<div style="font-size:13px"></div><img src="https://drjairoulerio.net/dash/uploads/cumpleanos.png" alt="Inline image 1" width="544" height="483" data-image-whitelisted="" class="CToWUd a6T" tabindex="0"></div>
        <div style="font-size:13px"><br></div>
        <div style="font-size:13px"><br></div>
        <div><font size="4" face="times new roman, serif">SON LOS DESEOS DE</font></div>
        <div style="font-size:13px"><br></div>
        <div><div dir="ltr" data-smartmail="gmail_signature"><div dir="ltr"><img width="420" height="169" src="https://ci3.googleusercontent.com/mail-sig/AIorK4xRwl9PzQroveCml76Tz3I86JluvlFMP6CyiE2rNgkt3HOpA5R3-GtlWsbRGLubJR5lb4UqXd4" class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 1; left: 372px; top: 703px;"><div id=":1nq" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Descargar el archivo adjunto " data-tooltip-class="a1V" data-tooltip="Descargar"><div class="akn"><div class="aSK J-J5-Ji aYr"></div></div></div></div></div></div></div>';
        $dia_actual = date('d');
        $mes_actual = date('m');
        $query = $this->db->get(db_prefix() . 'clients')->result();	
        foreach($query as $cliente){

            $arr = explode('-', $cliente->birthday_date);
            $cumple_dia = $arr[2]; 
            $cumple_mes = $arr[1];            
            
            if($dia_actual==$cumple_dia && $mes_actual==$cumple_mes){
                
                if($cliente->client_email!=''){

                $from = $this->config->item('smtp_user');
                $to = $cliente->client_email;
                $subject = 'FELIZ CUMPLEAÑOS';
                $message = $htmlContent;       

                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($message);

                $this->email->send();

                }

            }

        } 
    }

    public function patient_review()
    {
        $this->load->config('email');
        $this->load->library('email');

        $htmlContent = '        
        <div style="font-size:13px"><br></div>
        <div><font size="4" face="times new roman, serif">Your experience is important to us!:</font></div>
        <h3>RealSelf:</h3>
        <a href="https://www.realself.com/review/write?dr_id=1162036" style="font-size:13px">https://www.realself.com/review/write?dr_id=1162036</a>
        <br><br><br>
        <h3>Google:</h3>
        <a href="https://g.page/r/CYdeoHEjtCGdEAI/review" style="font-size:13px">https://g.page/r/CYdeoHEjtCGdEAI/review</a>
        <br><br>
        <div><div dir="ltr" data-smartmail="gmail_signature"><div dir="ltr"><img width="420" height="169" src="https://ci3.googleusercontent.com/mail-sig/AIorK4xRwl9PzQroveCml76Tz3I86JluvlFMP6CyiE2rNgkt3HOpA5R3-GtlWsbRGLubJR5lb4UqXd4" class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 1; left: 372px; top: 703px;"><div id=":1nq" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Descargar el archivo adjunto " data-tooltip-class="a1V" data-tooltip="Descargar"><div class="akn"><div class="aSK J-J5-Ji aYr"></div></div></div></div></div></div></div>';
        $current_day = date("d-m-Y");
        $query = $this->db->get(db_prefix() . 'clients')->result();	
        
        foreach($query as $cliente){

            $proc_day = $cliente->pprocedures;
            $proc_day = strtotime($proc_day);
            $rev_day21 = strtotime('+21 day', $proc_day);
            $rev_day21 = date('d-m-Y', $rev_day21);   
                        
            if($current_day===$rev_day21){    
                
                if($cliente->client_email!=''){

                $from = $this->config->item('smtp_user');
                $to = $cliente->client_email;
                $subject = 'Surgery Review';
                $message = $htmlContent;       

                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($message);

                $this->email->send();

                } 

            }
        }
    }

    public function send_email_review($id)
    {            
        $this->load->config('email');
        $this->load->library('email');        

        $htmlContent = '        
        <div style="font-size:13px"><br></div>
        <div><font size="4" face="times new roman, serif">Your experience is important to us!:</font></div>
        <h3>RealSelf:</h3>
        <a href="https://www.realself.com/review/write?dr_id=1162036" style="font-size:13px">https://www.realself.com/review/write?dr_id=1162036</a>
        <br><br><br>
        <h3>Google:</h3>
        <a href="https://g.page/r/CYdeoHEjtCGdEAI/review" style="font-size:13px">https://g.page/r/CYdeoHEjtCGdEAI/review</a>
        <br><br>
        <div><div dir="ltr" data-smartmail="gmail_signature"><div dir="ltr"><img width="420" height="169" src="https://ci3.googleusercontent.com/mail-sig/AIorK4xRwl9PzQroveCml76Tz3I86JluvlFMP6CyiE2rNgkt3HOpA5R3-GtlWsbRGLubJR5lb4UqXd4" class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 1; left: 372px; top: 703px;"><div id=":1nq" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Descargar el archivo adjunto " data-tooltip-class="a1V" data-tooltip="Descargar"><div class="akn"><div class="aSK J-J5-Ji aYr"></div></div></div></div></div></div></div>';
        $this->db->where('userid',$id);
        $query = $this->db->get(db_prefix() . 'clients')->result();	
        foreach($query as $cliente){             
                
            if($cliente->client_email!=''){

            $from = $this->config->item('smtp_user');
            $to = $cliente->client_email;
            $subject = 'Surgery Review';
            $message = $htmlContent;       

            $this->email->from($from);
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);

            $sent = $this->email->send();

            if ($sent) {    
                return true;
            }
                return false;
            }
        } 
    }

    public function fbleads()
    {   
        $this->db->where('source', 5);  
        $this->db->where('reasignado', 0);
        $query = $this->db->get(db_prefix() . 'leads')->result();
        if(isset($query)){ 
        foreach($query as $lead){
            $this->db->where('role', 2);
            $this->db->where('active', 1);
            $this->db->where('asignado', 0);
            $query2 = $this->db->get(db_prefix() . 'staff')->row(0);
            if(isset($query2)){  
                $this->db->where('id', $lead->id);
                $this->db->update(db_prefix() . 'leads', [
                    'assigned' => $query2->staffid,
                    'reasignado' => 1,
                ]);
                $this->db->where('staffid', $query2->staffid);
                $this->db->update(db_prefix() . 'staff', [
                    'asignado' => 1,
                ]); 
            }else{
                $this->db->where('role', 2);
                $this->db->where('active', 1);
                $this->db->where('asignado', 1);
                $query3 = $this->db->get(db_prefix() . 'staff')->result();
                foreach($query3 as $staff){
                    $this->db->where('staffid', $staff->staffid);
                    $this->db->update(db_prefix() . 'staff', [
                        'asignado' => 0,
                    ]); 
                }
                $this->db->where('role', 2);
                $this->db->where('active', 1);
                $this->db->where('asignado', 0);
                $query4 = $this->db->get(db_prefix() . 'staff')->row(0);

                $this->db->where('id', $lead->id);
                $this->db->update(db_prefix() . 'leads', [
                    'assigned' => $query4->staffid,
                    'reasignado' => 1,
                ]);

                $this->db->where('staffid', $query4->staffid);
                $this->db->update(db_prefix() . 'staff', [
                    'asignado' => 1,
                ]);  
            }             
        }
        }
    }
}

?>
