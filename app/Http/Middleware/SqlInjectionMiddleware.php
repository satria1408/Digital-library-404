<?php

namespace App\Http\Middleware;

use App\Models\SecurityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SqlInjectionMiddleware
{
    /**
     * Daftar pola SQL Injection
     */
    private array $patterns = [

        // Login bypass
        '/\b(or|and)\b\s+\d+\s*=\s*\d+/i',

        // UNION SELECT
        '/union\s+select/i',

        // INSERT INTO
        '/insert\s+into/i',

        // UPDATE ... SET
        '/update\s+.+\s+set/i',

        // DELETE FROM
        '/delete\s+from/i',

        // DROP TABLE
        '/drop\s+table/i',

        // ALTER TABLE
        '/alter\s+table/i',

        // CREATE TABLE
        '/create\s+table/i',

        // TRUNCATE TABLE
        '/truncate\s+table/i',

        // EXEC / EXECUTE
        '/exec(\s|\()/i',

        // SLEEP()
        '/sleep\s*\(/i',

        // BENCHMARK()
        '/benchmark\s*\(/i',

        // INFORMATION_SCHEMA
        '/information_schema/i',

        // LOAD_FILE()
        '/load_file\s*\(/i',

        // INTO OUTFILE
        '/into\s+outfile/i',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $this->scanInput($request->all(), $request);

        return $next($request);
    }

    /**
     * Scan seluruh input (termasuk array)
     */
    private function scanInput(array $inputs, Request $request): void
    {
        foreach ($inputs as $value) {

            if (is_array($value)) {
                $this->scanInput($value, $request);
                continue;
            }

            if (!is_string($value)) {
                continue;
            }

            foreach ($this->patterns as $pattern) {

                if (preg_match($pattern, $value)) {

                    SecurityLog::create([
                        'user_id'      => Auth::id(),
                        'ip_address'   => $request->ip(),
                        'url'          => $request->fullUrl(),
                        'method'       => $request->method(),
                        'payload'      => $value,
                        'attack_type'  => 'SQL Injection',
                        'user_agent'   => $request->userAgent(),
                    ]);

                    abort(403, 'SQL Injection Terdeteksi.');
                }
            }
        }
    }
}