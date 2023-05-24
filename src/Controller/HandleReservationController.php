<?php

namespace App\Controller;

use App\Repository\ReservedTableRepository;
use App\Services\ReservationService;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateImmutableType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPSTORM_META\type;

class HandleReservationController extends AbstractController
{
    #[Route('/handle/reservation', name: 'app_handle_reservation', methods: 'POST')]
    public function index(Request $request, ReservationService $reservation, ReservedTableRepository $reservedTableRepository): Response
    {
        $ajax = json_decode($request->getContent());
        $date = getdate($ajax->timestamp / 1000);
        $schedule = $reservation->getHours($date['wday']);
        $choiceDate = new \DateTimeImmutable();
        $resevedTables = $reservedTableRepository->findByReservedForDate(DateTimeImmutable::createFromMutable(date_create(date('Y-m-d', $date[0]))));
        return new JsonResponse([
            'openingTime' => $schedule->getOpeningTime(),
            'closingTime' => $schedule->getClosingTime(),
            'breakStartTime' => $schedule->getBreakStartTime(),
            'breakEndTime' => $schedule->getBreakEndTime(),
            'choiceTime' => $choiceDate->setTimestamp($date[0]),
            'reservedTimes' => array_map(fn($reservedTable) => $reservedTable->getReservedFor(), $resevedTables)
        ], 200, ['Content-type' => 'application/json']);
       
    }
}
