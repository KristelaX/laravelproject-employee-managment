<?php
namespace App\Services\Contracts;
use Illuminate\Http\Request;
interface CalculateSalaryInterface
{
    /**
     * Calculate .
     *
     *  @param int $value
     * @return int
     */
    public function calculateNettSalary($value);

    /**
     * Get the unique identifier for the user.
     * 
     *  @param int $value
     * @return int
     */
    public function calculatePit($value);

    /**
     * Get the password for the user.
     *
    *  @param int $value
     * @return int
     */
    public function calculateEmployeeSocialContribution($value);

    /**
     * Get the token value for the "remember me" session.
     *
     *  @param int $value
     * @return int
     */

    public function calculateEmployerSocialContribution($value);

    /**
     * Get the column name for the "remember me" token.
     *
     *  @param int $value
     * @return int
     */
    public function calculateHealthContribution($value);
    
    /**
     * Get users.
     *
     *  @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAllUsers(Request $request);
}