<?php

namespace App\Console\Commands;

use App\Mail\TestEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email : The email address to send the test to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify email configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("Sending test email to: {$email}");
        
        try {
            Mail::to($email)->send(new TestEmail([
                'sent_at' => now(),
                'command' => 'email:test'
            ]));
            
            $this->info("✅ Test email sent successfully!");
            $this->line("Check your inbox at: {$email}");
            $this->line("");
            $this->line("If you don't receive the email, check:");
            $this->line("1. Your .env mail configuration");
            $this->line("2. Spam/Junk folder");
            $this->line("3. Mail server logs");
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to send test email: " . $e->getMessage());
            $this->line("");
            $this->line("Check your mail configuration in .env:");
            $this->line("MAIL_MAILER=smtp");
            $this->line("MAIL_HOST=your-smtp-server");
            $this->line("MAIL_PORT=587");
            $this->line("MAIL_USERNAME=your-username");
            $this->line("MAIL_PASSWORD=your-password");
            $this->line("MAIL_FROM_ADDRESS=noreply@kingscastlehotel.com");
            
            return 1;
        }
        
        return 0;
    }
}
