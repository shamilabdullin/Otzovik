<?php


namespace App\Repository;


use App\Entity\Review;

interface ReviewRepositoryInterface
{
    /**
     * @return array
     */
    public function getAllReview(): array;

    /**
     * @param int $reviewId
     * @return Review
     */
    public function getOneReview(int $reviewId): object;

    /**
     * @param Review $review
     * @return Review
     */
    public function setCreateReview(Review $review): object;

    /**
     * @param Review $review
     * @return Review
     */
    public function setUpdateCategory(Review $review): object;

    /**
     * @param Review $review
     */
    public function setDeleteReview(Review $review);
}