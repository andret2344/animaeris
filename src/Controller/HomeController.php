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
		return $this->render('home/index.html.twig', $this->pageData());
	}

	#[Route('/kontakt', name: 'contact', methods: ['POST'])]
	public function contact(Request $request): Response
	{
		$input = [
			'name' => trim((string)$request->request->get('name', '')),
			'email' => trim((string)$request->request->get('email', '')),
			'phone' => trim((string)$request->request->get('phone', '')),
			'class' => trim((string)$request->request->get('class_type', '')),
			'message' => trim((string)$request->request->get('message', '')),
			'consent' => $request->request->has('consent'),
		];

		$errors = $this->validateContact($input, (string)$request->request->get('_token', ''));

		if ($errors !== []) {
			return $this->render('home/index.html.twig', $this->pageData([
				'contact_errors' => $errors,
				'contact_old' => $input,
			]), new Response('', Response::HTTP_UNPROCESSABLE_ENTITY));
		}

		return $this->render('home/contact_success.html.twig', ['name' => $input['name']]);
	}

	/**
	 * @param array<string, mixed> $input
	 * @return array<string, string>
	 */
	private function validateContact(array $input, string $token): array
	{
		$errors = [];

		if (!$this->isCsrfTokenValid('contact', $token)) {
			$errors['_token'] = 'Sesja wygasła. Odśwież stronę i spróbuj ponownie.';
		}
		if ($input['name'] === '') {
			$errors['name'] = 'Podaj imię i nazwisko.';
		}
		if ($input['email'] === '') {
			$errors['email'] = 'Podaj adres e-mail.';
		} else if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Podaj poprawny adres e-mail.';
		}
		if ($input['message'] === '') {
			$errors['message'] = 'Napisz treść wiadomości.';
		}
		if (!$input['consent']) {
			$errors['consent'] = 'Zgoda na przetwarzanie danych jest wymagana.';
		}

		return $errors;
	}

	/**
	 * @param array<string, mixed> $extra
	 * @return array<string, mixed>
	 */
	private function pageData(array $extra = []): array
	{
		return $extra + [
				'classes' => $this->getClasses(),
				'schedule' => $this->getSchedule(),
				'pricing' => $this->getPricing(),
				'faq' => $this->getFaq(),
				'trainers' => $this->getTrainers(),
				'contact_errors' => [],
				'contact_old' => [],
			];
	}

	private function getClasses(): array
	{
		return [
			// WELLNESS
			[
				'name' => 'Strefa Wellness',
				'type' => 'wellness',
				'img' => 'foto3',
				'orient' => 'square',
				'desc' => 'Masaż relaksacyjny, kinesiotaping i praca z ciałem - przestrzeń stworzona do regeneracji ciała i ducha.',
				'price' => 'Rezerwacje: Booksy',
				'tag' => ''
			],

			// PREMIUM
			[
				'name' => 'Aerial Hoop',
				'type' => 'premium',
				'img' => 'foto4',
				'orient' => 'square',
				'desc' => 'Koło cyrkowe - łączy siłę, gibkość i artyzm. Idealne dla osób, które marzą o efektownych figurach w powietrzu.',
				'price' => 'od 45 zł',
				'tag' => ''
			],
			[
				'name' => 'Aerial Yoga',
				'type' => 'premium',
				'img' => 'foto5',
				'orient' => 'square',
				'desc' => 'Joga w hamaku - odciąża kręgosłup, poprawia elastyczność i daje poczucie lekkości oraz relaksu.',
				'price' => 'od 45 zł',
				'tag' => ''
			],
			[
				'name' => 'Samoobrona',
				'type' => 'premium',
				'img' => 'foto6',
				'orient' => 'square',
				'desc' => 'Zajęcia w formie warsztatów, w nieregularnych terminach, w edycjach: Open, dla kobiet, dla seniorów.',
				'price' => 'Warsztaty',
				'tag' => 'Warsztaty'
			],

			// SOFT
			[
				'name' => 'Rozciąganie',
				'type' => 'soft',
				'img' => 'rozciaganie',
				'orient' => 'square',
				'desc' => 'Kompleksowe zajęcia rozciągające - poprawiają elastyczność i redukują napięcia nagromadzone w ciele.',
				'price' => 'od 35 zł',
				'tag' => ''
			],
			[
				'name' => 'Mobilność i rollowanie',
				'type' => 'soft',
				'img' => 'mobilnosc',
				'orient' => 'square',
				'desc' => 'Praca z ciałem skupiona na mobilności stawów i rozluźnieniu powięzi za pomocą rollowania.',
				'price' => 'od 35 zł',
				'tag' => ''
			],
			[
				'name' => 'Zdrowa postawa',
				'type' => 'soft',
				'img' => 'postawa',
				'orient' => 'square',
				'desc' => 'Prozdrowotne zajęcia: korekcja postawy, redukcja bólu pleców i lepsza świadomość własnego ciała.',
				'price' => 'od 35 zł',
				'tag' => ''
			],
			[
				'name' => 'Wzmacnianie',
				'type' => 'soft',
				'img' => 'wzmacnianie',
				'orient' => 'square',
				'desc' => 'Budujemy siłę pod sporty aerial i nie tylko. Dobra baza to podstawa prewencji kontuzji.',
				'price' => 'od 35 zł',
				'tag' => ''
			],
			[
				'name' => 'Siła i core',
				'type' => 'soft',
				'img' => 'core',
				'orient' => 'square',
				'desc' => 'Mięśnie głębokie, koordynacja i stabilizacja: brzuch, plecy, miednica, przepona, prawidłowe przenoszenie siły.',
				'price' => 'od 35 zł',
				'tag' => ''
			],
			[
				'name' => 'Trening funkcjonalny',
				'type' => 'soft',
				'img' => 'funkcjonalny',
				'orient' => 'square',
				'desc' => 'Ruchy życia codziennego - wzmacniasz ciało, angażując jednocześnie wiele grup mięśniowych.',
				'price' => 'od 35 zł',
				'tag' => ''
			],
			[
				'name' => 'Cardio Dance',
				'type' => 'soft',
				'img' => 'cardio-dance',
				'orient' => 'square',
				'desc' => 'Energiczne zajęcia taneczno-cardio. Spalisz kalorie i wyjdziesz z uśmiechem.',
				'price' => 'od 35 zł',
				'tag' => ''
			],
			[
				'name' => 'Zajęcia usprawniające',
				'type' => 'soft',
				'img' => 'usprawnianie',
				'orient' => 'square',
				'desc' => 'Ćwiczenia dla seniorów i osób po kontuzjach, które chcą wrócić do pełni sprawności fizycznej.',
				'price' => 'od 35 zł',
				'tag' => ''
			],
		];
	}

	private function getSchedule(): array
	{
		return [
			'Poniedziałek' => [
				['time' => '08:00', 'name' => 'Mobilność i rollowanie', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '09:00', 'name' => 'Cardio Dance', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '16:00', 'name' => 'Aerial Yoga', 'room' => 'Sala Liliowa', 'type' => 'premium'],
				['time' => '17:00', 'name' => 'Rozciąganie', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '17:00', 'name' => 'Hamaki technika', 'room' => 'Sala Liliowa', 'type' => 'premium'],
				['time' => '18:00', 'name' => 'Aerial Hoop Kids', 'room' => 'Sala Liliowa', 'type' => 'premium'],
				['time' => '19:00', 'name' => 'Aerial Hoop Open', 'room' => 'Sala Liliowa', 'type' => 'premium'],
			],
			'Wtorek' => [
				['time' => '08:00', 'name' => 'Zdrowa postawa', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '09:00', 'name' => 'Wzmacnianie', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '09:00', 'name' => 'Aerial Hoop Basic', 'room' => 'Sala Liliowa', 'type' => 'premium'],
				['time' => '17:00', 'name' => 'Zajęcia usprawniające', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '18:00', 'name' => 'Cardio stepy', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '19:00', 'name' => 'Aerial Hoop Intermediate', 'room' => 'Sala Liliowa', 'type' => 'premium'],
			],
			'Środa' => [
				['time' => '08:00', 'name' => 'Cardio Dance', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '09:00', 'name' => 'Rozciąganie', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '17:00', 'name' => 'Trening funkcjonalny', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '17:00', 'name' => 'Aerial Hoop Basic', 'room' => 'Sala Liliowa', 'type' => 'premium'],
				['time' => '18:00', 'name' => 'Siła i core', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '18:00', 'name' => 'Aerial Hoop Choreo', 'room' => 'Sala Liliowa', 'type' => 'premium'],
				['time' => '19:00', 'name' => 'Mobilność i rollowanie', 'room' => 'Sala Cream', 'type' => 'soft'],
			],
			'Czwartek' => [
				['time' => '08:00', 'name' => 'Zdrowa postawa', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '08:00', 'name' => 'Aerial Hoop Basic', 'room' => 'Sala Liliowa', 'type' => 'premium'],
				['time' => '09:00', 'name' => 'Mobilność i rollowanie', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '16:00', 'name' => 'Hamaki technika', 'room' => 'Sala Liliowa', 'type' => 'premium'],
				['time' => '17:00', 'name' => 'Aerial Yoga', 'room' => 'Sala Liliowa', 'type' => 'premium'],
				['time' => '17:00', 'name' => 'Pole Dance Intermediate', 'room' => 'Sala Cream', 'type' => 'premium'],
				['time' => '18:00', 'name' => 'Pole Dance Basic', 'room' => 'Sala Cream', 'type' => 'premium'],
				['time' => '19:00', 'name' => 'Pole Dance Choreo', 'room' => 'Sala Cream', 'type' => 'premium'],
			],
			'Piątek' => [
				['time' => '08:00', 'name' => 'Rozciąganie', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '09:00', 'name' => 'Zajęcia usprawniające', 'room' => 'Sala Cream', 'type' => 'soft'],
				['time' => '17:00', 'name' => 'Pole Dance Basic', 'room' => 'Sala Cream', 'type' => 'premium'],
				['time' => '18:00', 'name' => 'Mobilność i rollowanie', 'room' => 'Sala Cream', 'type' => 'soft'],
			],
			'Sobota' => [],
			'Niedziela' => [],
		];
	}

	private function getPricing(): array
	{
		return [
			'soft' => [
				'name' => 'Zajęcia SOFT',
				'description' => 'Mobilność i rollowanie, Rozciąganie, Wzmacnianie, Zdrowa postawa, Siła i core, Cardio Dance, Zajęcia usprawniające, Trening funkcjonalny',
				'items' => [
					['label' => 'Pojedyncze wejście', 'price' => '35 zł'],
					['label' => 'Karnet 4 wejścia', 'price' => '125 zł'],
					['label' => 'Karnet 8 wejść', 'price' => '240 zł'],
				],
				'note' => 'Z kartą sportową: dopłata sprzętowa 10 zł',
			],
			'premium' => [
				'name' => 'Zajęcia PREMIUM',
				'description' => 'Aerial Hoop, Aerial Yoga, Hamaki technika, Samoobrona',
				'items' => [
					['label' => 'Pojedyncze wejście', 'price' => '45 zł'],
					['label' => 'Karnet 4 wejścia', 'price' => '175 zł'],
					['label' => 'Karnet 8 wejść', 'price' => '320 zł'],
				],
				'note' => 'Z kartą sportową: dopłata sprzętowa 20 zł',
			],
			'membership' => [
				'name' => 'Członkowstwo',
				'description' => 'Pełen dostęp do studia w stałej, miesięcznej cenie.',
				'price' => '650 zł',
				'per' => '/ miesiąc',
				'features' => [
					'Nielimitowane wejścia na wszystkie zajęcia',
					'Dostęp do open studio',
					'Priorytet przy zapisach',
					'Zniżki na wynajem sal',
				],
			],
			'other' => [
				['name' => 'Open Studio', 'desc' => 'Zajęcia bez trenera', 'price' => '30 zł'],
				['name' => 'Wynajem sali', 'desc' => 'Przy większej liczbie godzin - cena do negocjacji', 'price' => '150 zł / godz.'],
				['name' => 'Urodziny, integracja, wieczory panieńskie', 'desc' => 'Wydarzenia skrojone na miarę', 'price' => 'Wycena indywidualna'],
			],
		];
	}

	private function getFaq(): array
	{
		return [
			[
				'q' => 'Czy potrzebuję doświadczenia, żeby zacząć?',
				'a' => 'Absolutnie nie! Nasze zajęcia są dostępne dla osób w każdym wieku i na każdym poziomie zaawansowania. Trenerki zadbają o to, by pierwsze kroki były bezpieczne i przyjemne.'
			],
			[
				'q' => 'Dla kogo są zajęcia w Animaeris?',
				'a' => 'Dla każdego - od dzieci po seniorów. Znajdziesz u nas zarówno spokojne zajęcia regeneracyjne i usprawniające, jak i bardziej wymagające zajęcia techniczne aerial.'
			],
			[
				'q' => 'Co zabrać na pierwsze zajęcia?',
				'a' => 'Wygodny strój do ćwiczeń, bidon z wodą i dobre nastawienie. Na zajęcia aerial najlepiej przynieść legginsy - chronią skórę przy pracy na sprzęcie.'
			],
			[
				'q' => 'Jak działają karnety?',
				'a' => 'Karnety ważne są 30 dni od pierwszego wejścia. Możesz z nich korzystać na dowolnych zajęciach z danej kategorii (SOFT lub PREMIUM).'
			],
//			[
//				'q' => 'Czy akceptujecie karty sportowe?',
//				'a' => 'Tak! Z kartą sportową obowiązuje dopłata sprzętowa: 10 zł przy zajęciach SOFT i 20 zł przy zajęciach PREMIUM.'
//			],
			[
				'q' => 'Ile osób jest na zajęciach?',
				'a' => 'Dbamy o komfort i bezpieczeństwo - grupy są kameralne, maksymalnie 10 osób. Trenerka może poświęcić uwagę każdej osobie.'
			],
			[
				'q' => 'Czy mogę zorganizować u Was wydarzenie?',
				'a' => 'Oczywiście! Organizujemy urodziny, wyjścia firmowe i wieczory panieńskie. Napisz do nas - przygotujemy indywidualny scenariusz i wycenę.'
			],
			[
				'q' => 'Jak wynająć salę?',
				'a' => 'Wynajem to 150 zł/godz. Przy dłuższych rezerwacjach cena do negocjacji. Napisz do nas na WhatsApp, by ustalić szczegóły.'
			],
		];
	}

	private function getTrainers(): array
	{
		return [
			[
				'name' => 'Zuza Łabanowska',
				'role' => 'Założycielka · Masażystka & trenerka Aerial',
				'img' => 'zuza',
				'desc' => 'Masażystka, certyfikowana instruktorka Pole Dance i stretchingu, a także zawodniczka i trenerka Aerial Hoop. Ceni bezpośredniość i uważa, że nie ma głupich pytań - z chęcią odpowie na każde.',
				'tags' => ['Aerial Hoop', 'Rozciąganie', 'Mobilność']
			],
			[
				'name' => 'Hania Grajewska',
				'role' => 'Trenerka personalna & fizjoterapeutka',
				'img' => 'hania',
				'desc' => 'Trenerka i pasjonatka aktywności fizycznej w każdym wydaniu (byle w akompaniamencie dobrej muzyki i równie dobrego towarzystwa). Studiowała na Akademii Wychowania Fizycznego i Sportu w Gdańsku na kierunkach Fizjoterapia oraz Trener Personalny i Fitness.',
				'tags' => ['Trening funkcjonalny', 'Siła i core', 'Wzmacnianie']
			],
			[
				'name' => 'Eliza Zaremba',
				'role' => 'Trenerka Yogi & Aerial Yogi',
				'img' => 'eliza',
				'desc' => 'Tykająca bomba energetyczna, która nauczy Cię także spokoju. Trenerka Yogi i Aerial Yogi z wieloletnim doświadczeniem, organizatorka tematycznych wyjazdów relaksacyjnych. Wegetarianka i miłośniczka natury. Uwielbia podróże.',
				'tags' => ['Aerial Yoga', 'Yoga', 'Hamaki']
			],
		];
	}
}
