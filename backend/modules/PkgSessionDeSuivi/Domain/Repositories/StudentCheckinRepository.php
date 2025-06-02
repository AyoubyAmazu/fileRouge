<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;

use Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckin;
use Modules\PkgSessionDeSuivi\Domain\Interfaces\StudentCheckinRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Entities\Period;

class StudentCheckinRepository implements StudentCheckinRepositoryInterface
{
   protected $studentCheckinRepository;
   protected $periodRepository;
   public function __construct(StudentCheckin $studentCheckinRepository, Period $periodRepository)
   {
       $this->studentCheckinRepository = $studentCheckinRepository;
       $this->periodRepository = $periodRepository;
   }
   public function getAll()
   {
       return $this->studentCheckinRepository->all();
   }

   public function todayStudentCheckin()
   {
       return $this->studentCheckinRepository->where('created_at', today())->count();
   }
   public function getStudentCheckinByPeriod($promotionId = null)
   {
       $query = $this->studentCheckinRepository
           ->selectRaw('period_id, COUNT(*) as total')
           ->groupBy('period_id')
           ->with('period');
   
       if ($promotionId) {
           $query->whereHas('student.apprenant.groupe.promotion', function ($q) use ($promotionId) {
               $q->where('id', $promotionId);
           });
       }
   
       return $query->get();
   }
   
   public function getStudentCheckinByPeriodAvg()
   {
        return $this->studentCheckinRepository->selectRaw('AVG(checkin_count) as avg')
        ->from(function ($query) {
            $query->selectRaw('period_id, COUNT(*) as checkin_count')
                ->from('student_checkins')
                ->groupBy('period_id');
        }, 'sub')
        ->value('avg');
   }
   public function getRecentStudentCheckins($promotionId = null)
   {
       // Get the latest period
       $latestPeriod = $this->periodRepository
           ->orderByDesc('start_date')
           ->first();
   
       if (!$latestPeriod) {
           return collect(); // Return empty if no periods exist
       }
   
       $query = $this->studentCheckinRepository
           ->with(['student.apprenant.groupe.promotion', 'period', 'checkinForm'])
           ->where('period_id', $latestPeriod->id)
           ->latest()
           ->take(10);
   
       if ($promotionId) {
           $query->whereHas('student.apprenant.groupe.promotion', function ($q) use ($promotionId) {
               $q->where('id', $promotionId);
           });
       }
   
       return $query->get();
   }
   
   
}       
