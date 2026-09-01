param(
    [Parameter(Mandatory = $true)][string]$DocPath,
    [Parameter(Mandatory = $true)][string]$OutPath
)
$ErrorActionPreference = 'Stop'
$word = New-Object -ComObject Word.Application
$word.Visible = $false
$word.DisplayAlerts = 0
$result = @{}
try {
    $doc = $word.Documents.Open($DocPath, $false, $true)
    $count = $doc.Paragraphs.Count
    for ($i = 1; $i -le $count; $i++) {
        $p = $doc.Paragraphs.Item($i)
        $text = $p.Range.Text
        if ($text -match '^Gambar 4\.(\d+)') {
            $num = [int]$Matches[1]
            # wdActiveEndPageNumber = 3
            $page = $p.Range.Information(3)
            $result[$num] = $page
        }
    }
    $doc.Close($false)
}
finally {
    $word.Quit()
}
$result.GetEnumerator() | Sort-Object { [int]$_.Key } | ForEach-Object {
    "{0}`t{1}" -f $_.Key, $_.Value
} | Out-File -FilePath $OutPath -Encoding utf8
