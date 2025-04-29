<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host       = env('MAIL_HOST') ?? 'smtp.gmail.com';
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = env('MAIL_USERNAME') ?? 'caballeroaldrin02@gmail.com';
        $this->mailer->Password   = env('MAIL_PASSWORD') ?? 'igtpplhigzmehdjc';
        $this->mailer->SMTPSecure = env('MAIL_ENCRYPTION') ?? 'ssl';
        $this->mailer->Port       = env('MAIL_PORT') ?? 465;
    }


    public function sendOtp($to, $otp)
    {
        try {
            // Recipients
            $this->mailer->setFrom(env('MAIL_FROM_ADDRESS') ?? 'caballeroaldrin02@gmail.com', env('MAIL_FROM_NAME') ?? 'WebInn');
            $this->mailer->addAddress($to);

            // Content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'OTP Verification';
            $this->mailer->Body    = '<div style="background: #f0f0f0; padding: 30px;">
                                            <p style="padding: 20px; font-size: 20px; background: #fff; color: #222; box-shadow: 2px 2px 10px rgba(0,0,0,0.1); border-radius: 10px; text-align: center; margin: auto;">
                                                Please use the following One Time Password (OTP) to change your password: 
                                                <b style="font-size: 30px; display: block; margin-top: 10px; text-decoration: underline;">' . $otp . '</b>
                                                <br>Warning: Do not share this OTP with anyone. 
                                                <br> Thank you!
                                            </p>
                                        </div>';

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }



    // mail for sending attendance every month
    /**
     * Send the Quarterly Attendance Report via email.
     *
     * @param string $to Recipient's email address.
     * @param array $data An array containing attendance details:
     *                    - 'grade' (string): The grade of the student.
     *                    - 'strand' (string): The strand of the student.
     *                    - 'section' (string): The section of the student.
     *                    - 'quarter' (string): The current quarter (e.g., "1st Quarter").
     *                    - 'absences' (array): List of absences.
     *                    - 'highlighted_absences' (array): List of highlighted unexcused absences.
     *                    - 'patterns_of_tardiness' (array): Patterns of tardiness.
     *                    - 'student_name' (string): Name of the student.
     * @return bool True if the email is sent successfully, otherwise false.
     */
    public function sendAttendance($to, $data)
    {
        try {
            // Configure the sender's email and name
            $this->mailer->setFrom(
                env('MAIL_FROM_ADDRESS', 'caballeroaldrin02@gmail.com'),
                env('MAIL_FROM_NAME', 'WebInn')
            );

            // Add the recipient's email address
            $this->mailer->addAddress($to);

            // Email content setup
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Quarterly Attendance Report - WebInn';

            // Build the email body using the provided data
            $absencesList = '';
            foreach ($data['absences'] as $absence) {
                $absencesList .= "<li>Date: {$absence['date']} - Reason: {$absence['reason']}</li>";
            }

            $highlightedAbsencesList = '';
            foreach ($data['highlighted_absences'] as $absence) {
                $highlightedAbsencesList .= "<li>{$absence}</li>";
            }

            $tardinessPatternsList = '';
            foreach ($data['patterns_of_tardiness'] as $pattern) {
                $tardinessPatternsList .= "<li>{$pattern}</li>";
            }

            // Email body with dynamic content
            $this->mailer->Body = '
        <!DOCTYPE html>
        <html>
        <head>
    <meta name="google-site-verification" content="tU_6Yfck8dwvd94C-xcOivOWlkmvLrw3SELDsWyvA_g">

            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; }
                .header { text-align: center; font-size: 24px; font-weight: bold; margin-bottom: 20px; }
                .content { margin-bottom: 20px; }
                .highlight { color: #d9534f; font-weight: bold; }
                .footer { margin-top: 20px; font-size: 12px; color: #777; text-align: center; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">Quarterly Attendance Report</div>
                <div class="content">
                    <p>Dear Parent/Guardian,</p>
                    <p>Below is the Quarterly Attendance Report for your child, <strong>' . $data['student_name'] . '</strong>, for the <strong>' . $data['quarter'] . '</strong> in <strong>Grade ' . $data['grade'] . ' ' . $data['strand'] . ' ' . $data['section'] . '</strong> at <strong>Philippine Technological Institute of Science Arts and Trade Inc</strong>. This report includes a summary of their absences and tardiness during the quarter.</p>

                    <h4>List of Absences:</h4>
                    <ul>' . $absencesList . '</ul>

                    <h4>Highlighted Unexcused Absences:</h4>
                    <ul class="highlight">' . $highlightedAbsencesList . '</ul>
                    <p class="highlight">These absences were marked as unexcused and should be addressed to ensure proper documentation and support moving forward.</p>

                    <h4>Patterns of Tardiness:</h4>
                    <ul>' . $tardinessPatternsList . '</ul>

                    <p>' . $data['student_name'] . ' has been late to class a total of <strong>' . count($data['patterns_of_tardiness']) . ' times</strong> during the ' . $data['quarter'] . '.</p>

                    <p>We recommend discussing these attendance patterns with ' . $data['student_name'] . ' to understand any challenges they may be facing. As per school policy, <strong>three unexcused absences</strong> in a quarter will result in a <span class="highlight">WARNING</span> for potential course drop.</p>

                    <p>If you have any questions or concerns, please feel free to contact us at <a href="mailto:support@arktech.edu">support@arktech.edu</a>.</p>
                </div>
                <div class="footer">
                    &copy; ' . date("Y") . ' Philippine Technological Institute of Science Arts and Trade Inc. All rights reserved.
                </div>
            </div>
        </body>
        </html>';

            // Send the email
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            // Log or handle the error
            return false;
        }
    }




    public function sendAttendanceV2($to, $data)
    {
        try {
            // Configure the sender's email and name
            $this->mailer->setFrom(
                env('MAIL_FROM_ADDRESS', 'caballeroaldrin02@gmail.com'),
                env('MAIL_FROM_NAME', 'WebInn')
            );

            // Add the recipient's email address
            $this->mailer->addAddress($to);

            // Email content setup
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Quarterly Report - WebInn';



            // Email body with dynamic content
            $this->mailer->Body = $data['htmlBody'];

            // Send the email
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            // Log or handle the error
            return false;
        }
    }
}
