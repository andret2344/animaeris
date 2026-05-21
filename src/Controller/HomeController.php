<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'schedule' => $this->getSchedule(),
            'pricing'  => $this->getPricing(),
            'faq'      => $this->getFaq(),
            'trainers' => $this->getTrainers(),
        ]);
    }

    #[Route('/kontakt', name: 'contact', methods: ['POST'])]
    public function contact(Request $request): Response
    {
        $name = htmlspecialchars($request->request->get('name', ''));
        return $this->render('home/contact_success.html.twig', ['name' => $name]);
    }

    private function getSchedule(): array
    {
        return [
            'Poniedziałek' => [
                ['time' => '09:00', 'name' => 'Rozciąganie',           'type' => 'soft',    'duration' => 60],
                ['time' => '17:30', 'name' => 'Wzmacnianie',           'type' => 'soft',    'duration' => 60],
                ['time' => '19:00', 'name' => 'Aerial Hoop',           'type' => 'premium', 'duration' => 75],
            ],
            'Wtorek' => [
                ['time' => '10:00', 'name' => 'Mobilność i rollowanie','type' => 'soft',    'duration' => 60],
                ['time' => '18:00', 'name' => 'Flying Pole',           'type' => 'premium', 'duration' => 75],
                ['time' => '19:30', 'name' => 'Cardio Dance',          'type' => 'soft',    'duration' => 60],
            ],
            'Środa' => [
                ['time' => '09:00', 'name' => 'Aerial Yoga',           'type' => 'premium', 'duration' => 75],
                ['time' => '17:00', 'name' => 'Zajęcia usprawniające', 'type' => 'soft',    'duration' => 60],
                ['time' => '19:00', 'name' => 'Hamaki',                'type' => 'premium', 'duration' => 75],
            ],
            'Czwartek' => [
                ['time' => '10:00', 'name' => 'Wzmacnianie',           'type' => 'soft',    'duration' => 60],
                ['time' => '17:30', 'name' => 'Aerial Hoop',           'type' => 'premium', 'duration' => 75],
                ['time' => '19:00', 'name' => 'Samoobrona',            'type' => 'premium', 'duration' => 75],
            ],
            'Piątek' => [
                ['time' => '09:00', 'name' => 'Rozciąganie',           'type' => 'soft',    'duration' => 60],
                ['time' => '17:00', 'name' => 'Cardio Dance',          'type' => 'soft',    'duration' => 60],
                ['time' => '18:30', 'name' => 'Flying Pole',           'type' => 'premium', 'duration' => 75],
            ],
            'Sobota' => [
                ['time' => '10:00', 'name' => 'Aerial Yoga',           'type' => 'premium', 'duration' => 75],
                ['time' => '11:30', 'name' => 'Mobilność i rollowanie','type' => 'soft',    'duration' => 60],
                ['time' => '13:00', 'name' => 'Open Studio',           'type' => 'open',    'duration' => 120],
            ],
        ];
    }

    private function getPricing(): array
    {
        return [
            'soft' => [
                'name'        => 'Zajęcia SOFT',
                'description' => 'Mobilność i rollowanie, Rozciąganie, Wzmacnianie, Cardio Dance, Zajęcia usprawniające',
                'items'       => [
                    ['label' => 'Pojedyncze wejście', 'price' => '35 zł'],
                    ['label' => 'Karnet 4 wejścia',   'price' => '125 zł'],
                    ['label' => 'Karnet 8 wejść',     'price' => '240 zł'],
                ],
                'note' => 'Z kartą sportową: dopłata sprzętowa 10 zł',
            ],
            'premium' => [
                'name'        => 'Zajęcia PREMIUM',
                'description' => 'Aerial Hoop, Flying Pole, Aerial Yoga, Hamaki, Samoobrona',
                'items'       => [
                    ['label' => 'Pojedyncze wejście', 'price' => '45 zł'],
                    ['label' => 'Karnet 4 wejścia',   'price' => '175 zł'],
                    ['label' => 'Karnet 8 wejść',     'price' => '320 zł'],
                ],
                'note' => 'Z kartą sportową: dopłata sprzętowa 20 zł',
            ],
            'other' => [
                ['name' => 'Open Studio',   'desc' => 'Zajęcia bez trenera',                                        'price' => '30 zł'],
                ['name' => 'Wynajem sali',  'desc' => 'Przy większej liczbie godzin — cena do negocjacji',          'price' => '150 zł / godz.'],
                ['name' => 'Członkostwo',   'desc' => 'Nielimitowane wejścia na każde zajęcia i Open Studio',       'price' => '650 zł / mies.'],
            ],
        ];
    }

    private function getFaq(): array
    {
        return [
            ['q' => 'Czy potrzebuję doświadczenia, żeby zacząć?',
             'a' => 'Absolutnie nie! Nasze zajęcia są dostępne dla osób na każdym poziomie zaawansowania. Trenerki zadbają o to, by pierwsze kroki były bezpieczne i przyjemne.'],
            ['q' => 'Co zabrać na pierwsze zajęcia?',
             'a' => 'Wygodny strój do ćwiczeń, bidon z wodą i dobre nastawienie. Na zajęcia aerial najlepiej przynieść legginsy — chronią skórę przy pracy na aparaturze.'],
            ['q' => 'Jak działają karnety?',
             'a' => 'Karnety ważne są 30 dni od pierwszego wejścia. Możesz z nich korzystać na dowolnych zajęciach z danej kategorii (SOFT lub PREMIUM).'],
            ['q' => 'Czy akceptujecie karty sportowe?',
             'a' => 'Tak! Akceptujemy Multisport, OK System i FitProfit. Przy zajęciach SOFT obowiązuje dopłata 10 zł, przy PREMIUM — 20 zł.'],
            ['q' => 'Ile osób jest na zajęciach?',
             'a' => 'Dbamy o komfort i bezpieczeństwo — grupy są kameralne, maksymalnie 8–10 osób. Trenerka może poświęcić uwagę każdej uczestniczce.'],
            ['q' => 'Czy mogę przyjść na zajęcia próbne?',
             'a' => 'Oczywiście! Pierwsze zajęcia próbne w cenie standardowego wejścia. Skontaktuj się z nami, żebyśmy zarezerwowały dla Ciebie miejsce.'],
            ['q' => 'Jak wynająć salę?',
             'a' => 'Wynajem to 150 zł/godz. Przy dłuższych rezerwacjach cena do negocjacji. Napisz do nas, by ustalić szczegóły.'],
        ];
    }

    private function getTrainers(): array
    {
        return [
            ['name' => 'Anna Kowalska',    'role' => 'Założycielka & Trenerka Aerial',
             'desc' => 'Pasjonatka aerial arts od ponad 10 lat. Certyfikowana instruktorka Aerial Hoop i Flying Pole. Jej zajęcia łączą technikę z artystyczną ekspresją.',
             'tags' => ['Aerial Hoop', 'Flying Pole', 'Stretching']],
            ['name' => 'Marta Wiśniewska', 'role' => 'Trenerka Wellness',
             'desc' => 'Fizjoterapeutka i trenerka ruchu. Specjalizuje się w zajęciach rehabilitacyjnych. Pomoże Ci poznać swoje ciało na nowo.',
             'tags' => ['Mobilność', 'Wzmacnianie', 'Aerial Yoga']],
            ['name' => 'Karolina Nowak',   'role' => 'Trenerka Tańca',
             'desc' => 'Tancerka z wieloletnim doświadczeniem scenicznym. Jej energia na Cardio Dance jest zaraźliwa — czysta radość z ruchu.',
             'tags' => ['Cardio Dance', 'Hamaki', 'Samoobrona']],
        ];
    }
}
