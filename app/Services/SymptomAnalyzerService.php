<?php

namespace App\Services;

class SymptomAnalyzerService
{
    /**
     * Database gejala dan penyakit dengan bobot
     */
    private $symptomDatabase = [
        'pusing' => [
            'hipertensi' => 0.3,
            'anemia' => 0.25,
            'vertigo' => 0.2,
            'migrain' => 0.15,
            'dehidrasi' => 0.1
        ],
        'demam' => [
            'infeksi_virus' => 0.25,
            'infeksi_bakteri' => 0.2,
            'dbd' => 0.15,
            'tifus' => 0.15,
            'malaria' => 0.1,
            'covid19' => 0.15
        ],
        'batuk' => [
            'infeksi_saluran_pernapasan' => 0.3,
            'asma' => 0.2,
            'bronkitis' => 0.2,
            'pneumonia' => 0.15,
            'tbc' => 0.1,
            'covid19' => 0.05
        ],
        'mual' => [
            'gastritis' => 0.3,
            'keracunan_makanan' => 0.2,
            'migrain' => 0.15,
            'vertigo' => 0.15,
            'kehamilan' => 0.1,
            'hepatitis' => 0.1
        ],
        'diare' => [
            'keracunan_makanan' => 0.35,
            'gastroenteritis' => 0.25,
            'ibs' => 0.2,
            'infeksi_usus' => 0.15,
            'intoleransi_makanan' => 0.05
        ]
    ];

    /**
     * Database detail penyakit
     */
    private $diseaseDatabase = [
        'hipertensi' => [
            'name' => 'Hipertensi (Tekanan Darah Tinggi)',
            'definition' => 'Kondisi dimana tekanan darah sistolik ≥140 mmHg dan/atau diastolik ≥90 mmHg',
            'causes' => ['Faktor genetik', 'Pola makan tinggi garam', 'Obesitas', 'Kurang olahraga', 'Stress'],
            'symptoms' => ['Pusing', 'Sakit kepala', 'Penglihatan kabur', 'Nyeri dada', 'Sesak napas'],
            'complications' => ['Stroke', 'Serangan jantung', 'Gagal ginjal', 'Gangguan penglihatan']
        ],
        'anemia' => [
            'name' => 'Anemia (Kurang Darah)',
            'definition' => 'Kondisi dimana tubuh kekurangan sel darah merah sehat atau hemoglobin',
            'causes' => ['Kekurangan zat besi', 'Kehilangan darah', 'Penyakit kronis', 'Kekurangan vitamin B12'],
            'symptoms' => ['Pusing', 'Lemas', 'Pucat', 'Sesak napas', 'Jantung berdebar'],
            'complications' => ['Gagal jantung', 'Gangguan pertumbuhan', 'Infeksi berulang']
        ],
        'dbd' => [
            'name' => 'Demam Berdarah Dengue (DBD)',
            'definition' => 'Penyakit infeksi yang disebabkan oleh virus dengue yang ditularkan nyamuk Aedes aegypti',
            'causes' => ['Virus dengue', 'Gigitan nyamuk Aedes aegypti'],
            'symptoms' => ['Demam tinggi mendadak', 'Sakit kepala', 'Nyeri otot', 'Ruam kulit', 'Pendarahan'],
            'complications' => ['Syok dengue', 'Pendarahan hebat', 'Gagal organ']
        ],
        'gastritis' => [
            'name' => 'Gastritis (Radang Lambung)',
            'definition' => 'Peradangan pada dinding lambung yang menyebabkan iritasi',
            'causes' => ['Infeksi H. pylori', 'Penggunaan NSAID', 'Stress', 'Alkohol', 'Makanan pedas'],
            'symptoms' => ['Mual', 'Muntah', 'Perut kembung', 'Nyeri ulu hati', 'Kehilangan nafsu makan'],
            'complications' => ['Tukak lambung', 'Pendarahan lambung', 'Kanker lambung']
        ],
        'keracunan_makanan' => [
            'name' => 'Keracunan Makanan',
            'definition' => 'Penyakit yang disebabkan konsumsi makanan yang terkontaminasi bakteri, virus, atau racun',
            'causes' => ['Bakteri (Salmonella, E.coli)', 'Virus', 'Parasit', 'Racun alami', 'Bahan kimia'],
            'symptoms' => ['Mual', 'Muntah', 'Diare', 'Kram perut', 'Demam'],
            'complications' => ['Dehidrasi', 'Gangguan elektrolit', 'Sepsis']
        ]
    ];

    /**
     * Analisis gejala dan berikan persentase kemungkinan penyakit
     */
    public function analyzeSymptoms($symptoms)
    {
        $symptoms = array_map('strtolower', $symptoms);
        $diseaseScores = [];

        foreach ($symptoms as $symptom) {
            if (isset($this->symptomDatabase[$symptom])) {
                foreach ($this->symptomDatabase[$symptom] as $disease => $weight) {
                    if (!isset($diseaseScores[$disease])) {
                        $diseaseScores[$disease] = 0;
                    }
                    $diseaseScores[$disease] += $weight;
                }
            }
        }

        // Normalisasi skor menjadi persentase
        $maxScore = max($diseaseScores ?: [0]);
        $probabilities = [];

        foreach ($diseaseScores as $disease => $score) {
            $probability = ($score / $maxScore) * 100;
            $probabilities[$disease] = round($probability);
        }

        // Sort berdasarkan probabilitas (descending)
        arsort($probabilities);

        return $probabilities;
    }

    /**
     * Dapatkan detail penyakit
     */
    public function getDiseaseDetails($diseaseKey)
    {
        return $this->diseaseDatabase[$diseaseKey] ?? null;
    }

    /**
     * Extract gejala dari teks user
     */
    public function extractSymptomsFromText($text)
    {
        $text = strtolower($text);
        $foundSymptoms = [];

        foreach (array_keys($this->symptomDatabase) as $symptom) {
            if (strpos($text, $symptom) !== false) {
                $foundSymptoms[] = $symptom;
            }
        }

        return $foundSymptoms;
    }

    /**
     * Buat rekomendasi berdasarkan gejala
     */
    public function generateRecommendations($symptoms, $topDiseases)
    {
        $recommendations = [];

        // Rekomendasi umum
        $recommendations[] = "Segera konsultasi ke dokter untuk mendapat diagnosis yang akurat";
        
        // Rekomendasi berdasarkan gejala spesifik
        if (in_array('demam', $symptoms)) {
            $recommendations[] = "Minum banyak air putih untuk mencegah dehidrasi";
            $recommendations[] = "Istirahat yang cukup";
            $recommendations[] = "Kompres dengan air hangat jika demam tinggi";
        }

        if (in_array('mual', $symptoms)) {
            $recommendations[] = "Hindari makanan berlemak dan pedas";
            $recommendations[] = "Makan dalam porsi kecil tapi sering";
            $recommendations[] = "Minum teh hangat tanpa gula";
        }

        if (in_array('pusing', $symptoms)) {
            $recommendations[] = "Hindari berdiri mendadak";
            $recommendations[] = "Pastikan cukup istirahat";
            $recommendations[] = "Periksa tekanan darah";
        }

        if (in_array('diare', $symptoms)) {
            $recommendations[] = "Minum oralit untuk mengganti cairan tubuh";
            $recommendations[] = "Hindari makanan berlemak dan berserat tinggi";
            $recommendations[] = "Konsumsi makanan yang mudah dicerna";
        }

        // Rekomendasi kapan harus ke UGD
        $emergencySymptoms = ['sesak napas berat', 'nyeri dada', 'demam tinggi berkelanjutan', 'pendarahan'];
        $recommendations[] = "Segera ke UGD jika mengalami: " . implode(', ', $emergencySymptoms);

        return $recommendations;
    }

    /**
     * Validasi apakah pertanyaan terkait kesehatan
     */
    public function isHealthRelatedQuery($query)
    {
        $healthKeywords = [
            'sakit', 'penyakit', 'gejala', 'obat', 'dokter', 'rumah sakit', 'kesehatan',
            'demam', 'batuk', 'pilek', 'pusing', 'mual', 'diare', 'nyeri', 'bengkak',
            'medis', 'diagnosis', 'pengobatan', 'terapi', 'vaksin', 'imunisasi'
        ];

        $query = strtolower($query);
        
        foreach ($healthKeywords as $keyword) {
            if (strpos($query, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }
}