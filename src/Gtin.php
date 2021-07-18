<?php

declare(strict_types=1);

namespace Real\Validator;

/**
 * A GTIN is a string of digits that uniquely identifies a trade item (a product that is bought and sold). A GTIN is
 * globally unique, meaning that no two products in the world share the same GTIN. There is a GS1 Standard
 * called the "GTIN Allocation Rules" which helps to ensure this. For example, the GTIN Allocation Rules specify that
 * if the same product is available in two different sizes, such as a one-liter bottle of soft drink and a two-liter
 * bottle of the same soft drink, these are considered different products and so must have different GTINs. Two
 * instances of the same product will have the same GTIN; for example, all one-liter bottles of the same soft drink
 * will carry the same GTIN.
 */
interface Gtin
{
    /**
     * A GTIN can consist of 12, 13, 14, or 8 digits.
     * The reason for different lengths is mostly historical:
     *
     * The original GTIN, introduced in the year 1973, was 12 digits long. At the time, it was called the
     * Universal Product Code (UPC). Today, it is officially called GTIN-12, although the UPC name is still used.
     *
     * When use of the GTIN was expanded beyond the US the GTIN-13 was introduced. Originally, the
     * GTIN-13 was only used outside the US and Canada; today, the GTIN-13 may be used anywhere in the
     * world although in the US and Canada the GTIN-12 is still much more common.
     *
     * The GTIN-12 and GTIN-13 are used on trade items sold to consumers at point-of-sale terminals. When
     * the use of GTIN was expanded to non-consumer sale units, such as cases and pallets which are traded
     * in the supply chain but not sold to consumers in that form, the GTIN-14 was introduced. GTIN-14 may
     * not be used on trade items sold to consumers at point-of-sale. GTIN-14s are typically used to identify
     * cases, pallets, and other similar non-consumer logistic units (but a case or pallet could also be
     * identified by a GTIN-12 or GTIN-13 instead of a GTIN-14).
     *
     * The GTIN-8 was introduced to allow for a smaller bar code to fit on small consumer-sale packages that
     * could not easily accommodate the full GTIN-12 or GTIN-13.
     */
    public function length(): int;

    /**
     * Based on GTIN's length, there are only four variations of GTINs,
     * called GTIN-12, GTIN-13, GTIN-14, and GTIN-8, respectively.
     */
    public function variation(): string;

    /**
     * It may seem complex to have four different lengths of GTINs;
     * however, processing is simplified by the fact that any GTIN
     * may be written as a 14-digit string by adding ‘0’ characters to the left.
     */
    public function padded(): string;

    /**
     * GTIN's value having a length corresponding to its variation
     */
    public function key(): string;

    /**
     * An original value used to build a GTIN from
     */
    public function origin(): string;

    /**
     * GTIN-14 adds another component - the "Indicator" digit, which
     * can be 1-8 for logistic unit not sold at point-of-sale (case, pallet).
     * Indicator digit "9" is reserved for variable measure trade items,
     * and is always "0" for consumer sale unit (GTIN-8, GTIN-12, GTIN-13)
     */
    public function indicator(): int;

    /**
     * The rightmost digit of a GTIN is called the Check Digit,
     * calculated as a function of the other digits by a mathematical formula,
     * designed in a way the check digit will catch most data entry errors.
     * In particular, if any one digit is entered incorrectly, or any
     * two adjacent digits are transposed, the check digit will not validate.
     */
    public function checkDigit(): int;

    /**
     * GTIN capacity is allocated to the GS1 Member Organizations in large ranges by the GS1 Global Office.
     * The range allocated to a GS1 Member Organization all have the same value for digits N2, N3, and N4. These
     * three digits together are called the GS1 Prefix. The GS1 Prefix is a convenient way to refer to the range
     * of GTINs allocated to a particular GS1 Member Organization
     */
    public function prefix(): string;
}
