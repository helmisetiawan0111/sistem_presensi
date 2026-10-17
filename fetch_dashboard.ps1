Add-Type -AssemblyName System.Net.Http
$client = New-Object System.Net.Http.HttpClient
$client.Timeout = [TimeSpan]::FromSeconds(15)
try {
    $response = $client.GetAsync("http://127.0.0.1:8000/dashboard").Result
    $content = $response.Content.ReadAsStringAsync().Result
    $content | Out-File -FilePath "dashboard_output.html" -Encoding UTF8 -Force
    Write-Output "Status: $($response.StatusCode), Length: $($content.Length)"
    # search for key markers
    if ($content -match 'KILO') { Write-Output "KILO found" }
    if ($content -match 'semua hadir') { Write-Output "semua hadir FOUND" }
    if ($content -match 'Tidak Hadir') { Write-Output "Tidak Hadir found" }
    if ($content -match 'totalTdk') { Write-Output "totalTdk found" }
} catch {
    Write-Output "Error: $($_.Exception.Message)"
}
