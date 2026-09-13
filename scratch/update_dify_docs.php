<?php
$files = [
    'docs/DIFY_RAG_KNOWLEDGE_DESA_ROMBIYAH_BARAT.md' => 'docs/DIFY_RAG_KNOWLEDGE_DESA_ROMBIYA_BARAT.md',
    'docs/DIFY_RAG_KNOWLEDGE_DESA_ROMBIYAH_BARAT.txt' => 'docs/DIFY_RAG_KNOWLEDGE_DESA_ROMBIYA_BARAT.txt',
];

foreach ($files as $src => $dest) {
    if (file_exists($src)) {
        $content = file_get_contents($src);
        $updated = str_replace('Rombiyah', 'Rombiya', $content);
        file_put_contents($dest, $updated);
        file_put_contents($src, $updated); // also update original
        echo "Updated $src and $dest\n";
    }
}
