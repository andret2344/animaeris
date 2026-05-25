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
            'classes'  => $this->getClasses(),
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

    private function getClasses(): array
    {
        return [
            // WELLNESS
            ['name' => 'Strefa Wellness', 'type' => 'wellness', 'img' => 'wellness', 'orient' => 'landscape',
             'desc' => 'Masaż relaksacyjny, kinesiotaping i praca z ciałem — przestrzeń stworzona do regeneracji ciała i ducha.',
             'price' => 'Wycena indyw.', 'tag' => ''],

            // PREMIUM
            ['name' => 'Aerial Hoop', 'type' => 'premium', 'img' => 'forest', 'orient' => 'portrait',
             'desc' => 'Koło cyrkowe — łączy siłę, gibkość i artyzm. Idealne dla osób, które marzą o efektownych figurach w powietrzu.',
             'price' => 'od 45 zł', 'tag' => ''],
            ['name' => 'Aerial Yoga', 'type' => 'premium', 'img' => 'eliza', 'orient' => 'square',
             'desc' => 'Joga w hamaku — odciąża kręgosłup, poprawia elastyczność i daje poczucie lekkości oraz relaksu.',
             'price' => 'od 45 zł', 'tag' => ''],
            ['name' => 'Hamaki', 'type' => 'premium', 'img' => 'studio', 'orient' => 'landscape',
             'desc' => 'Zajęcia w hamakach: rozciąganie, regeneracja i odwrócone pozycje, które delikatnie odciążają ciało.',
             'price' => 'od 45 zł', 'tag' => ''],
            ['name' => 'Flying Pole', 'type' => 'premium', 'img' => 'pole-blue', 'orient' => 'portrait',
             'desc' => 'Pole dance w powietrzu — spektakularny trening siły, zwinności i gracji.',
             'price' => 'od 45 zł', 'tag' => 'Wkrótce'],
            ['name' => 'Samoobrona', 'type' => 'premium', 'img' => 'pole-dark', 'orient' => 'portrait',
             'desc' => 'Zajęcia w formie warsztatów, w nieregularnych terminach, w edycjach: Open, dla kobiet, dla seniorów.',
             'price' => 'Warsztaty', 'tag' => 'Warsztaty'],

            // SOFT
            ['name' => 'Rozciąganie', 'type' => 'soft', 'img' => 'hoop-split', 'orient' => 'portrait',
             'desc' => 'Kompleksowe zajęcia rozciągające — poprawiają elastyczność i redukują napięcia nagromadzone w ciele.',
             'price' => 'od 35 zł', 'tag' => ''],
            ['name' => 'Mobilność i rollowanie', 'type' => 'soft', 'img' => 'band', 'orient' => 'portrait',
             'desc' => 'Praca z ciałem skupiona na mobilności stawów i rozluźnieniu powięzi za pomocą rollowania.',
             'price' => 'od 35 zł', 'tag' => ''],
            ['name' => 'Zdrowa postawa', 'type' => 'soft', 'img' => 'massage-body', 'orient' => 'landscape',
             'desc' => 'Prozdrowotne zajęcia: korekcja postawy, redukcja bólu pleców i lepsza świadomość własnego ciała.',
             'price' => 'od 35 zł', 'tag' => ''],
            ['name' => 'Wzmacnianie', 'type' => 'soft', 'img' => 'hania', 'orient' => 'portrait',
             'desc' => 'Budujemy siłę pod sporty aerial i nie tylko. Dobra baza to podstawa prewencji kontuzji.',
             'price' => 'od 35 zł', 'tag' => ''],
            ['name' => 'Siła i core', 'type' => 'soft', 'img' => 'sled', 'orient' => 'portrait',
             'desc' => 'Mięśnie głębokie, koordynacja i stabilizacja: brzuch, plecy, miednica, przepona, prawidłowe przenoszenie siły.',
             'price' => 'od 35 zł', 'tag' => ''],
            ['name' => 'Trening funkcjonalny', 'type' => 'soft', 'img' => 'band', 'orient' => 'portrait',
             'desc' => 'Ruchy życia codziennego — wzmacniasz ciało, angażując jednocześnie wiele grup mięśniowych.',
             'price' => 'od 35 zł', 'tag' => ''],
            ['name' => 'Cardio Dance', 'type' => 'soft', 'img' => 'pole-dark', 'orient' => 'portrait',
             'desc' => 'Energiczne zajęcia taneczno-cardio. Spalisz kalorie i wyjdziesz z uśmiechem.',
             'price' => 'od 35 zł', 'tag' => ''],
            ['name' => 'Zajęcia usprawniające', 'type' => 'soft', 'img' => 'massage-table', 'orient' => 'landscape',
             'desc' => 'Ćwiczenia dla seniorów i osób po kontuzjach, które chcą wrócić do pełni sprawności fizycznej.',
             'price' => 'od 35 zł', 'tag' => ''],
        ];
    }

    private function getSchedule(): array
    {
        return [
            'Poniedziałek' => [
                ['time' => '09:00', 'name' => 'Rozciąganie',            'type' => 'soft',    'duration' => 60],
                ['time' => '17:30', 'name' => 'Wzmacnianie',            'type' => 'soft',    'duration' => 60],
                ['time' => '19:00', 'name' => 'Aerial Hoop',            'type' => 'premium', 'duration' => 75],
            ],
            'Wtorek' => [
                ['time' => '10:00', 'name' => 'Mobilność i rollowanie', 'type' => 'soft',    'duration' => 60],
                ['time' => '17:00', 'name' => 'Siła i core',            'type' => 'soft',    'duration' => 60],
                ['time' => '18:30', 'name' => 'Cardio Dance',           'type' => 'soft',    'duration' => 60],
            ],
            'Środa' => [
                ['time' => '09:00', 'name' => 'Aerial Yoga',            'type' => 'premium', 'duration' => 75],
                ['time' => '17:00', 'name' => 'Zdrowa postawa',         'type' => 'soft',    'duration' => 60],
                ['time' => '19:00', 'name' => 'Hamaki',                 'type' => 'premium', 'duration' => 75],
            ],
            'Czwartek' => [
                ['time' => '10:00', 'name' => 'Trening funkcjonalny',   'type' => 'soft',    'duration' => 60],
                ['time' => '17:30', 'name' => 'Aerial Hoop',            'type' => 'premium', 'duration' => 75],
                ['time' => '19:00', 'name' => 'Rozciąganie',            'type' => 'soft',    'duration' => 60],
            ],
            'Piątek' => [
                ['time' => '09:00', 'name' => 'Zajęcia usprawniające',  'type' => 'soft',    'duration' => 60],
                ['time' => '17:00', 'name' => 'Cardio Dance',           'type' => 'soft',    'duration' => 60],
                ['time' => '18:30', 'name' => 'Aerial Yoga',            'type' => 'premium', 'duration' => 75],
            ],
            'Sobota' => [
                ['time' => '10:00', 'name' => 'Hamaki',                 'type' => 'premium', 'duration' => 75],
                ['time' => '11:30', 'name' => 'Mobilność i rollowanie', 'type' => 'soft',    'duration' => 60],
                ['time' => '13:00', 'name' => 'Open Studio',            'type' => 'open',    'duration' => 120],
            ],
        ];
    }

    private function getPricing(): array
    {
        return [
            'soft' => [
                'name'        => 'Zajęcia SOFT',
                'description' => 'Mobilność i rollowanie, Rozciąganie, Wzmacnianie, Zdrowa postawa, Siła i core, Cardio Dance, Zajęcia usprawniające, Trening funkcjonalny',
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
            'events' => [
                'name'        => 'Organizacja wydarzeń',
                'description' => 'Świętuj w ruchu — przygotujemy wydarzenie skrojone na miarę.',
                'features'    => [
                    'Urodziny i imprezy okolicznościowe',
                    'Wyjścia i integracje firmowe',
                    'Wieczory panieńskie',
                    'Indywidualny scenariusz i wycena',
                ],
            ],
            'other' => [
                ['name' => 'Open Studio',  'desc' => 'Zajęcia bez trenera',                              'price' => '30 zł'],
                ['name' => 'Wynajem sali', 'desc' => 'Przy większej liczbie godzin — cena do negocjacji', 'price' => '150 zł / godz.'],
            ],
        ];
    }

    private function getFaq(): array
    {
        return [
            ['q' => 'Czy potrzebuję doświadczenia, żeby zacząć?',
             'a' => 'Absolutnie nie! Nasze zajęcia są dostępne dla osób w każdym wieku i na każdym poziomie zaawansowania. Trenerki zadbają o to, by pierwsze kroki były bezpieczne i przyjemne.'],
            ['q' => 'Dla kogo są zajęcia w Animaeris?',
             'a' => 'Dla każdego — od dzieci po seniorów. Znajdziesz u nas zarówno spokojne zajęcia regeneracyjne i usprawniające, jak i bardziej wymagające zajęcia techniczne aerial.'],
            ['q' => 'Co zabrać na pierwsze zajęcia?',
             'a' => 'Wygodny strój do ćwiczeń, bidon z wodą i dobre nastawienie. Na zajęcia aerial najlepiej przynieść legginsy — chronią skórę przy pracy na sprzęcie.'],
            ['q' => 'Jak działają karnety?',
             'a' => 'Karnety ważne są 30 dni od pierwszego wejścia. Możesz z nich korzystać na dowolnych zajęciach z danej kategorii (SOFT lub PREMIUM).'],
            ['q' => 'Czy akceptujecie karty sportowe?',
             'a' => 'Tak! Z kartą sportową obowiązuje dopłata sprzętowa: 10 zł przy zajęciach SOFT i 20 zł przy zajęciach PREMIUM.'],
            ['q' => 'Ile osób jest na zajęciach?',
             'a' => 'Dbamy o komfort i bezpieczeństwo — grupy są kameralne, maksymalnie 10 osób. Trenerka może poświęcić uwagę każdej osobie.'],
            ['q' => 'Czy mogę zorganizować u Was wydarzenie?',
             'a' => 'Oczywiście! Organizujemy urodziny, wyjścia firmowe i wieczory panieńskie. Napisz do nas — przygotujemy indywidualny scenariusz i wycenę.'],
            ['q' => 'Jak wynająć salę?',
             'a' => 'Wynajem to 150 zł/godz. Przy dłuższych rezerwacjach cena do negocjacji. Napisz do nas na WhatsApp, by ustalić szczegóły.'],
        ];
    }

    private function getTrainers(): array
    {
        return [
            ['name' => 'Zuza Łabanowska', 'role' => 'Masażystka & trenerka Aerial', 'img' => 'zuza',
             'desc' => 'Masażystka, certyfikowana instruktorka Pole Dance i stretchingu, a także zawodniczka i trenerka Aerial Hoop. Ceni bezpośredniość i uważa, że nie ma głupich pytań — z chęcią odpowie na każde.',
             'tags' => ['Aerial Hoop', 'Rozciąganie', 'Mobilność']],
            ['name' => 'Hania Grajewska', 'role' => 'Trenerka personalna & fizjoterapeutka', 'img' => 'hania',
             'desc' => 'Pasjonatka aktywności fizycznej w każdym wydaniu. Studiowała Fizjoterapię oraz Trener Personalny i Fitness na AWFiS w Gdańsku. Kompleksowo zadba o technikę ćwiczeń i ich dobór na każdym treningu.',
             'tags' => ['Trening funkcjonalny', 'Siła i core', 'Wzmacnianie']],
            ['name' => 'Eliza Zaremba', 'role' => 'Trenerka Yogi & Aerial Yogi', 'img' => 'eliza',
             'desc' => 'Tykająca bomba energetyczna, która nauczy Cię także spokoju. Trenerka Yogi i Aerial Yogi z wieloletnim doświadczeniem, organizatorka tematycznych wyjazdów relaksacyjnych. Miłośniczka natury i podróży.',
             'tags' => ['Aerial Yoga', 'Yoga', 'Hamaki']],
        ];
    }
}
